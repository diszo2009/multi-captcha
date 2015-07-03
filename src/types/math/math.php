<?php
/**
 * Created by PhpStorm.
 * User: Sameer Shelavale
 * Date: 5/14/14
 * Time: 5:39 PM
 */
namespace MultiCaptcha\Types;
use MultiCaptcha\BaseCaptcha;

class Math extends BaseCaptcha {

    var $description = "Answer following question if you are human";
    var $id = false;
    var $level = 3;

    var $tooltip = array(
        'en' => 'Answer the above mathematical question.'
    );

    var $helpHtml = array(
        'en' => 'Pleae answer the given mathematical question to prove that you are not a automated bot. <br/>It is required for avoiding spam.'
    );


    function generateQuestion( ){
        $symbols1 = array( '+', '-', 'X', '/' );
        $symbols2 = array( '+', '-', 'X' );

        $q = array();
        $q[] = rand(0,10);
        for( $i=1; $i < $this->level; $i++ ){
            //select operator

            if( $i == 1 && $q[0] != 0 ){
                $operator = $symbols1[array_rand( $symbols1 )];
            }else{
                $operator = $symbols2[array_rand( $symbols2 )];
            }

            //select operand
            if( $operator == '/' ){
                $factors = $this->getFactors( $q[0]);
                $operand = $factors[array_rand( $factors )];
            }elseif( $operator == 'X'  ){
                $operand = rand( 0, 5 );
            }else{
                $operand = rand( 0, 10 );
            }
            $q[] = $operator;
            $q[] = $operand;
        }

        $result['question']['type'] = 'text';
        $result['question']['content'] = implode( ' ',$q ).' = ';

        $result['description'] = $this->description;
        $result['answer'] = "{$this->expEval( $q )}";


        return $result;
    }

    function expEval( $exp = array() ){
        $str = str_replace( 'X', '*',  implode( $exp ) );
        return( eval('return '.$str.';') );
    }

    function getFactors( $number ){
        $result[] = 1;
        if( $number != 1){
            $result[] = $number;
        }
        $limit = $number;
        for( $i=2; $i < $limit; $i++ ){
            if( $number % $i == 0 ){
                $result[] = $i;
                $tmp = $number/$i;
                if( $tmp != $i ){
                    $result[] = $tmp;
                }
                $limit = $number/$i;
            }
        }
        return $result;
    }


} 