<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\SistemaExperto;

use app\SistemaExperto\regla;
use app\SistemaExperto\hecho;
use app\SistemaExperto\Pila;
use app\SistemaExperto\literal;
use app\SistemaExperto\bh;
use app\models\ResultadosExamen;
/**
 * Description of backwardchain
 *
 * @author root
 */
class backwardchain {
    private $reglasMarcadas;
    private $metasMarcadas;
    private $reglas;
    private $bh;
    
    private static $VALIDA="valida";
    private static $NO_VALIDA="no valida";
    private static $RESPUESTA="respuesta";
    
    private static $CANT_RESP='cantidad respuestas';
    private static $VAL_CANT_RESP=142;
    private static $PUNTUACION_PERCENTIL='puntuacion percentil';
    private static $IGUAL="igual";
    private static $EXAMEN='examen';
    private static $NO_IGUAL='no igual';
    
    private static $PERFIL='perfil';
    
    public static $DEFINIDO='definido';
    public static $NO_DEFINIDO='no definido';
    
    private static $DISCREPANCIA='discrepancia';
    private static $EXISTE='existe';
    private static $NO_EXISTE='no existe';
    
    private static $TODAS_A="todas A";
    private static $TODAS_B="todas B";
    private static $TODAS_C="todas C";
    private static $TODAS_D="todas D";
    private static $NRO_PROF_PREF="nro de profeciones preferias con nota >60";
    private static $DISCREPANCIA_PROF_PREF="discrepancia en profesiones preferidas";
    private static $plano='Plano';
    
    public static $SIN_CONCLUSION="sin conclusion";
    public static $SIN_INFORMACION="La persona necesita mas informacion sobre las carreras";
    
    function getBh() {
        return $this->bh;
    }

    function setBh($bh) {
        $this->bh = $bh;
    }

        
    function __construct() {
        $this->reglasMarcadas=array();
        $this->metasMarcadas=array();
        $this->reglas=array();
        $this->bh=new bh();
    }

    function bwcr(hecho $hecho){
        $h=$this->bh->existeHecho($hecho);
        if($h!=null){
            return $h;
        }else{
            $conjuntoConflictivo=  $this->buscarReglas($hecho);
            $contadorRegla=0;
            while(!empty($conjuntoConflictivo) && $h==NULL){
                $regla=$conjuntoConflictivo[$contadorRegla];
                unset($conjuntoConflictivo[$contadorRegla]);
                $metas=$regla->clonarAntecedente();
                $contadorLiteral=0;
                $PUEDE_QUE_DISPARE=TRUE;
                while(!empty($metas) && $PUEDE_QUE_DISPARE){
                    $meta=$metas[$contadorLiteral];
                    unset($metas[$contadorLiteral]);
                    $h=  $this->bwcr($meta,$this->bh);
                    if($h!=null){
                        $this->bh->addHecho($h);
                    }else{
                        $PUEDE_QUE_DISPARE=FALSE;
                    }
                    ++$contadorLiteral;
                }
                if($PUEDE_QUE_DISPARE){
                    if($this->disparaRegla($regla,$this->bh)){
                        $this->bh->addHecho($regla->getConsecuente());
                        $h=$regla->getConsecuente();
                    }else{
                        $h=null;
                    }
                }
                ++$contadorRegla;
            }
            return $h;
        }
    }
    
   
    private function disparaRegla(regla $r, bh $bh){
        $dispara=TRUE;
        foreach ($r->getAntecedente() as $literal){
            $dispara=$dispara && $this->disparaLiteral($literal, $bh);
        }
        return $dispara;
    }
    private function disparaLiteral(literal $literal, bh $bh){
        foreach ($bh->getHechos() as $i => $hecho){
            if(strcmp($hecho->getVariable(),$literal->getVariable())==0){
                return $this->dispara($literal, $hecho);
            }
        }
        return false;
    }
    private function dispara(literal $literal,hecho $hecho){
        if($literal->getEsNumerico()){
            switch ($literal->getOprel()){
                case literal::$DIFERENTE:
                    return $literal->getValor()!=$hecho->getValor();
                case literal::$IGUAL:
                    return $literal->getValor()==$hecho->getValor();
                case literal::$MAYOR:
                    return $hecho->getValor()>$literal->getValor();
                case literal::$MAYOR_IGUAL:
                    return $hecho->getValor()>=$literal->getValor();
                case literal::$MENOR:
                    return $hecho->getValor()<$literal->getValor();
                case literal::$MENOR_IGUAL:
                    return $hecho->getValor()<=$literal->getValor();
            }
        }else{
            switch ($literal->getOprel()){
                case literal::$IGUAL:
                    return strcmp($literal->getValor(),$hecho->getValor())==0?TRUE:FALSE;
                case literal::$DIFERENTE:
                    return strcmp($literal->getValor(),$hecho->getValor())==0?FALSE:TRUE;
            }
        }
    }
   
    private function buscarReglas(hecho $hecho){
        $conjunto_conflictivo=array();
        foreach ($this->reglas as $i => $regla){
            if(strcmp($regla->getConsecuente()->getVariable(),$hecho->getVariable())==0){
                $conjunto_conflictivo[]=$regla;
            }
        }
        return $conjunto_conflictivo;
    }


    function getReglas() {
        return $this->reglas;
    }

    function setReglas( $r) {
        $this->reglas[] = $r;
    }
    
    public function initBase($id_inscripcion){
        $cantR=0;
        $todasA=false;
        $todasB=false;
        $todasC=false;
        $todasD=false;
        $this->obtenerVariables($cantR, $todasA, $todasB, $todasC, $todasD,$id_inscripcion);
        
        $hecho2=new hecho();
        $hecho2->setVariable(self::$TODAS_A);
        $hecho2->setValor($todasA);
        $hecho2->setEsNumerico(TRUE);
        $this->bh->addHecho($hecho2);
        
        $hecho3=new hecho();
        $hecho3->setVariable(self::$TODAS_B);
        $hecho3->setValor($todasB);
        $hecho3->setEsNumerico(TRUE);
        $this->bh->addHecho($hecho3);
        
        $hecho4=new hecho();
        $hecho4->setVariable(self::$TODAS_C);
        $hecho4->setValor($todasC);
        $hecho4->setEsNumerico(TRUE);
        $this->bh->addHecho($hecho4);
        
        $hecho5=new hecho();
        $hecho5->setVariable(self::$TODAS_D);
        $hecho5->setValor($todasD);
        $hecho5->setEsNumerico(TRUE);
        $this->bh->addHecho($hecho5);
        $this->calcularNroProfPref($id_inscripcion);
        $this->obtenerDisprepancia($id_inscripcion);     
    }
    private function puntuacionIguales($id_inscripcion){
        $re=new ResultadosExamen();
       
        $resultados=$re->findAll(['id_inscripcion'=>$id_inscripcion]);//->where(['id_inscripcion'=>$id_inscripcion])->all();
        $valid=TRUE;
        foreach ($resultados as $aux=> $resultado){
            for($i=0;$i<count($resultados);$i++){
                if($i!=$aux)
                    $valid=$valid && $resultado->nota==$resultados[$i]->nota;
            }
        }
        $hecho6=new hecho();
        $hecho6->setVariable(self::$PUNTUACION_PERCENTIL);
        if($valid){
            $hecho6->setValor(self::$IGUAL);
        }else
            $hecho6->setValor(self::$NO_IGUAL);
        $hecho6->setEsNumerico(FALSE);
        $this->bh->addHecho($hecho6);
    }
    private function calcularNroProfPref($id_inscripcion){
        $hecho=new hecho();
        $hecho->setVariable(self::$NRO_PROF_PREF);
        $hecho->setEsNumerico(TRUE);
        $re=new ResultadosExamen();
        $resultados=$re->find()->where(['id_inscripcion'=>$id_inscripcion,'id_tipo'=>2,])->andWhere(['>=','nota',60])
                ->orderBy(['nota'=>SORT_DESC])->all();
        $valor=  count($resultados);
        $hecho->setValor($valor);
        $this->bh->addHecho($hecho);
        
    }
    private function obtenerDisprepancia($id_inscripcion){

        $discrepancia=new hecho();
        $discrepancia->setVariable(self::$DISCREPANCIA_PROF_PREF);
        $re=new ResultadosExamen();
        $resultados=$re->find()->where(['id_inscripcion'=>$id_inscripcion,'id_tipo'=>2])->andWhere(['>=','nota',60])
                ->limit(3)->orderBy(['nota'=>SORT_DESC])->all();
        $valid=FALSE;
        
        foreach ($resultados as $prof){
            $actividad=$re->find()->where(['id_inscripcion'=>$id_inscripcion,'id_tipo'=>1,
                'id_area'=>$prof->id_area])->one();
                if($actividad->nota>$prof->nota){
                    $diferencia=$actividad->nota-$prof->nota;
                }else{
                    $diferencia=$prof->nota-$actividad->nota;
                }
                $valid=$valid || ($diferencia>=0 && $diferencia<=25);
        }
        $discrepancia->setValor($valid?self::$NO_EXISTE:self::$EXISTE);
        $discrepancia->setEsNumerico(FALSE);
        $this->bh->addHecho($discrepancia);
    }
    private function obtenerVariables(&$cantR=0,&$todasA=false,&$todasB=false,
            &$todasC=false,&$todasD=false,$id){
            $sql="CALL obtenerVariables( :id, @cantR , @todasA , @todasB , "
                    . "@todasC , @todasD);";
        $command=  \Yii::$app->db->createCommand($sql);
        $command->bindValue(":id", $id,\PDO::PARAM_INT);
        $command->execute();
        $result = \Yii::$app->db->createCommand("select @cantR , @todasA , @todasB , @todasC , @todasD;")->queryAll();
        $r=$result[0];
        $cantR=(int)$r['@cantR'];
        $todasA=(int)$r['@todasA'];
        $todasB=(int)$r['@todasB'];
        $todasC=(int)$r['@todasC'];
        $todasD=(int)$r['@todasD'];
    }
    public function createRules(){
        $this->regla1();
        $this->regla2();
        $this->regla3();
        $this->regla4();
        $this->regla5();
        $this->regla6();
        $this->regla7();
        $this->regla8();
        $this->regla9();
        $this->regla10();
    }
    private function regla1(){
        $hecho=new hecho();
        $hecho->setVariable(self::$TODAS_A);
        $hecho->setValor(0);
        $hecho->setEsNumerico(true);
        $literal1=new literal();
        $literal1->setHecho($hecho);
        $literal1->setOprel(literal::$IGUAL);
        
        $hecho=new hecho();
        $hecho->setVariable(self::$TODAS_B);
        $hecho->setValor(0);
        $hecho->setEsNumerico(true);
        $literal2=new literal();
        $literal2->setHecho($hecho);
        $literal2->setOprel(literal::$IGUAL);
        
        $hecho=new hecho();
        $hecho->setVariable(self::$TODAS_C);
        $hecho->setValor(0);
        $hecho->setEsNumerico(true);
        $literal3=new literal();
        $literal3->setHecho($hecho);
        $literal3->setOprel(literal::$IGUAL);
        
        $hecho=new hecho();
        $hecho->setVariable(self::$TODAS_D);
        $hecho->setValor(0);
        $hecho->setEsNumerico(true);
        $literal4=new literal();
        $literal4->setHecho($hecho);
        $literal4->setOprel(literal::$IGUAL);
        
        $consecuente=new hecho();
        $consecuente->setVariable(self::$RESPUESTA);
        $consecuente->setValor(self::$VALIDA);
        $consecuente->setEsNumerico(FALSE);
        
        $regla1=new regla();
        $regla1->addLiteral($literal1);
        $regla1->addLiteral($literal2);
        $regla1->addLiteral($literal3);
        $regla1->addLiteral($literal4);
        $regla1->setConsecuente($consecuente);
        $this->reglas[]=$regla1;
    }
    private function regla2(){
        $hecho=new hecho();
        $hecho->setVariable(self::$TODAS_A);
        $hecho->setValor(1);
        $hecho->setEsNumerico(true);
        $literal1=new literal();
        $literal1->setHecho($hecho);
        $literal1->setOprel(literal::$IGUAL);
        
        $hecho=new hecho();
        $hecho->setVariable(self::$TODAS_B);
        $hecho->setValor(0);
        $hecho->setEsNumerico(true);
        $literal2=new literal();
        $literal2->setHecho($hecho);
        $literal2->setOprel(literal::$IGUAL);
        
        $hecho=new hecho();
        $hecho->setVariable(self::$TODAS_C);
        $hecho->setValor(0);
        $hecho->setEsNumerico(true);
        $literal3=new literal();
        $literal3->setHecho($hecho);
        $literal3->setOprel(literal::$IGUAL);
        
        $hecho=new hecho();
        $hecho->setVariable(self::$TODAS_D);
        $hecho->setValor(0);
        $hecho->setEsNumerico(true);
        $literal4=new literal();
        $literal4->setHecho($hecho);
        $literal4->setOprel(literal::$IGUAL);
        
        $consecuente=new hecho();
        $consecuente->setVariable(self::$RESPUESTA);
        $consecuente->setValor(self::$NO_VALIDA);
        $consecuente->setEsNumerico(FALSE);
        
        $regla1=new regla();
        $regla1->addLiteral($literal1);
        $regla1->addLiteral($literal2);
        $regla1->addLiteral($literal3);
        $regla1->addLiteral($literal4);
        $regla1->setConsecuente($consecuente);
        $this->reglas[]=$regla1;
    }
    public function regla3(){
        $hecho=new hecho();
        $hecho->setVariable(self::$TODAS_A);
        $hecho->setValor(0);
        $hecho->setEsNumerico(true);
        $literal1=new literal();
        $literal1->setHecho($hecho);
        $literal1->setOprel(literal::$IGUAL);
        
        $hecho=new hecho();
        $hecho->setVariable(self::$TODAS_B);
        $hecho->setValor(1);
        $hecho->setEsNumerico(true);
        $literal2=new literal();
        $literal2->setHecho($hecho);
        $literal2->setOprel(literal::$IGUAL);
        
        $hecho=new hecho();
        $hecho->setVariable(self::$TODAS_C);
        $hecho->setValor(0);
        $hecho->setEsNumerico(true);
        $literal3=new literal();
        $literal3->setHecho($hecho);
        $literal3->setOprel(literal::$IGUAL);
        
        $hecho=new hecho();
        $hecho->setVariable(self::$TODAS_D);
        $hecho->setValor(0);
        $hecho->setEsNumerico(true);
        $literal4=new literal();
        $literal4->setHecho($hecho);
        $literal4->setOprel(literal::$IGUAL);
        
        $consecuente=new hecho();
        $consecuente->setVariable(self::$RESPUESTA);
        $consecuente->setValor(self::$NO_VALIDA);
        $consecuente->setEsNumerico(FALSE);
        
        $regla1=new regla();
        $regla1->addLiteral($literal1);
        $regla1->addLiteral($literal2);
        $regla1->addLiteral($literal3);
        $regla1->addLiteral($literal4);
        $regla1->setConsecuente($consecuente);
        $this->reglas[]=$regla1;
        
    }
    private function regla4(){
        $hecho=new hecho();
        $hecho->setVariable(self::$TODAS_A);
        $hecho->setValor(0);
        $hecho->setEsNumerico(true);
        $literal1=new literal();
        $literal1->setHecho($hecho);
        $literal1->setOprel(literal::$IGUAL);
        
        $hecho=new hecho();
        $hecho->setVariable(self::$TODAS_B);
        $hecho->setValor(0);
        $hecho->setEsNumerico(true);
        $literal2=new literal();
        $literal2->setHecho($hecho);
        $literal2->setOprel(literal::$IGUAL);
        
        $hecho=new hecho();
        $hecho->setVariable(self::$TODAS_C);
        $hecho->setValor(1);
        $hecho->setEsNumerico(true);
        $literal3=new literal();
        $literal3->setHecho($hecho);
        $literal3->setOprel(literal::$IGUAL);
        
        $hecho=new hecho();
        $hecho->setVariable(self::$TODAS_D);
        $hecho->setValor(0);
        $hecho->setEsNumerico(true);
        $literal4=new literal();
        $literal4->setHecho($hecho);
        $literal4->setOprel(literal::$IGUAL);
        
        $consecuente=new hecho();
        $consecuente->setVariable(self::$RESPUESTA);
        $consecuente->setValor(self::$NO_VALIDA);
        $consecuente->setEsNumerico(FALSE);
        
        $regla1=new regla();
        $regla1->addLiteral($literal1);
        $regla1->addLiteral($literal2);
        $regla1->addLiteral($literal3);
        $regla1->addLiteral($literal4);
        $regla1->setConsecuente($consecuente);
        $this->reglas[]=$regla1;
    }
    private function regla5(){
        $hecho=new hecho();
        $hecho->setVariable(self::$TODAS_A);
        $hecho->setValor(0);
        $hecho->setEsNumerico(true);
        $literal1=new literal();
        $literal1->setHecho($hecho);
        $literal1->setOprel(literal::$IGUAL);
        
        $hecho=new hecho();
        $hecho->setVariable(self::$TODAS_B);
        $hecho->setValor(0);
        $hecho->setEsNumerico(true);
        $literal2=new literal();
        $literal2->setHecho($hecho);
        $literal2->setOprel(literal::$IGUAL);
        
        $hecho=new hecho();
        $hecho->setVariable(self::$TODAS_C);
        $hecho->setValor(0);
        $hecho->setEsNumerico(true);
        $literal3=new literal();
        $literal3->setHecho($hecho);
        $literal3->setOprel(literal::$IGUAL);
        
        $hecho=new hecho();
        $hecho->setVariable(self::$TODAS_D);
        $hecho->setValor(1);
        $hecho->setEsNumerico(true);
        $literal4=new literal();
        $literal4->setHecho($hecho);
        $literal4->setOprel(literal::$IGUAL);
        
        $consecuente=new hecho();
        $consecuente->setVariable(self::$RESPUESTA);
        $consecuente->setValor(self::$NO_VALIDA);
        $consecuente->setEsNumerico(FALSE);
        
        $regla1=new regla();
        $regla1->addLiteral($literal1);
        $regla1->addLiteral($literal2);
        $regla1->addLiteral($literal3);
        $regla1->addLiteral($literal4);
        $regla1->setConsecuente($consecuente);
        $this->reglas[]=$regla1;
    }
    private function regla6(){
        $hecho1=new hecho();
        $hecho1->setVariable(self::$RESPUESTA);
        $hecho1->setValor(self::$VALIDA);
        $hecho1->setEsNumerico(FALSE);
        
        $hecho2=new hecho();
        $hecho2->setVariable(self::$NRO_PROF_PREF);
        $hecho2->setValor(4);
        $hecho2->setEsNumerico(TRUE);
        
        $hecho3=new hecho();
        $hecho3->setVariable(self::$DISCREPANCIA_PROF_PREF);
        $hecho3->setValor(self::$NO_EXISTE);
        
        $literal1=new literal();
        $literal1->setHecho($hecho1);
        $literal1->setOprel(literal::$IGUAL);

        $literal2=new literal();
        $literal2->setHecho($hecho2);
        $literal2->setOprel(literal::$MENOR); 
        
        $literal3=new literal();
        $literal3->setHecho($hecho3);
        $literal3->setOprel(literal::$IGUAL);
        
        $consecuente=new hecho();
        $consecuente->setVariable(self::$PERFIL);
        $consecuente->setValor(self::$DEFINIDO);
        $consecuente->setEsNumerico(FALSE);
        
        $regla=new regla();
        $regla->addLiteral($literal1);
        $regla->addLiteral($literal2);
        $regla->addLiteral($literal3);
        $regla->setConsecuente($consecuente);
        $this->reglas[]=$regla;
    }
    private function regla7(){
        $hecho1=new hecho();
        $hecho1->setVariable(self::$RESPUESTA);
        $hecho1->setValor(self::$NO_VALIDA);
        $hecho1->setEsNumerico(FALSE);
        
        $literal1=new literal();
        $literal1->setHecho($hecho1);
        $literal1->setOprel(literal::$IGUAL);
        
        $consecuente=new hecho();
        $consecuente->setVariable(self::$PERFIL);
        $consecuente->setValor('Examen no valido');
        $consecuente->setEsNumerico(FALSE);
        
        $regla=new regla();
        $regla->addLiteral($literal1);
        $regla->setConsecuente($consecuente);
        $this->reglas[]=$regla;
    }
    private function regla8(){
        $hecho1=new hecho();
        $hecho1->setVariable(self::$RESPUESTA);
        $hecho1->setValor(self::$VALIDA);
        $hecho1->setEsNumerico(FALSE);
        
        $hecho2=new hecho();
        $hecho2->setVariable(self::$NRO_PROF_PREF);
        $hecho2->setValor(4);
        $hecho2->setEsNumerico(TRUE);
        
        $hecho3=new hecho();
        $hecho3->setVariable(self::$DISCREPANCIA_PROF_PREF);
        $hecho3->setValor(self::$NO_EXISTE);
        
        $literal1=new literal();
        $literal1->setHecho($hecho1);
        $literal1->setOprel(literal::$IGUAL);

        $literal2=new literal();
        $literal2->setHecho($hecho2);
        $literal2->setOprel(literal::$MAYOR_IGUAL); 
        
        $literal3=new literal();
        $literal3->setHecho($hecho3);
        $literal3->setOprel(literal::$IGUAL);
        
        $consecuente=new hecho();
        $consecuente->setVariable(self::$PERFIL);
        $consecuente->setValor(self::$plano);
        $consecuente->setEsNumerico(FALSE);
        
        $regla=new regla();
        $regla->addLiteral($literal1);
        $regla->addLiteral($literal2);
        $regla->addLiteral($literal3);
        $regla->setConsecuente($consecuente);
        $this->reglas[]=$regla;
    }
    private function regla9(){
        $hecho1=new hecho();
        $hecho1->setVariable(self::$RESPUESTA);
        $hecho1->setValor(self::$VALIDA);
        $hecho1->setEsNumerico(FALSE);
        
        $hecho2=new hecho();
        $hecho2->setVariable(self::$NRO_PROF_PREF);
        $hecho2->setValor(4);
        $hecho2->setEsNumerico(TRUE);
        
        $hecho3=new hecho();
        $hecho3->setVariable(self::$DISCREPANCIA_PROF_PREF);
        $hecho3->setValor(self::$EXISTE);
        
        $literal1=new literal();
        $literal1->setHecho($hecho1);
        $literal1->setOprel(literal::$IGUAL);

        $literal2=new literal();
        $literal2->setHecho($hecho2);
        $literal2->setOprel(literal::$MAYOR_IGUAL); 
        
        $literal3=new literal();
        $literal3->setHecho($hecho3);
        $literal3->setOprel(literal::$IGUAL);
        
        $consecuente=new hecho();
        $consecuente->setVariable(self::$PERFIL);
        $consecuente->setValor(self::$NO_DEFINIDO);
        $consecuente->setEsNumerico(FALSE);
        
        $regla=new regla();
        $regla->addLiteral($literal1);
        $regla->addLiteral($literal2);
        $regla->addLiteral($literal3);
        $regla->setConsecuente($consecuente);
        $this->reglas[]=$regla;
    }
    private function regla10(){
        $hecho1=new hecho();
        $hecho1->setVariable(self::$RESPUESTA);
        $hecho1->setValor(self::$VALIDA);
        $hecho1->setEsNumerico(FALSE);
        
        $hecho2=new hecho();
        $hecho2->setVariable(self::$NRO_PROF_PREF);
        $hecho2->setValor(4);
        $hecho2->setEsNumerico(TRUE);
        
        $hecho3=new hecho();
        $hecho3->setVariable(self::$DISCREPANCIA_PROF_PREF);
        $hecho3->setValor(self::$EXISTE);
        
        $literal1=new literal();
        $literal1->setHecho($hecho1);
        $literal1->setOprel(literal::$IGUAL);

        $literal2=new literal();
        $literal2->setHecho($hecho2);
        $literal2->setOprel(literal::$MENOR); 
        
        $literal3=new literal();
        $literal3->setHecho($hecho3);
        $literal3->setOprel(literal::$IGUAL);
        
        $consecuente=new hecho();
        $consecuente->setVariable(self::$PERFIL);
        $consecuente->setValor(self::$NO_DEFINIDO);
        $consecuente->setEsNumerico(FALSE);
        
        $regla=new regla();
        $regla->addLiteral($literal1);
        $regla->addLiteral($literal2);
        $regla->addLiteral($literal3);
        $regla->setConsecuente($consecuente);
        $this->reglas[]=$regla;
    }
}
