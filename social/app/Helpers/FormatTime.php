<?php

namespace App\Helpers;

class FormatTime
{

    public static function time($date)
    {
        $current_date = new \DateTime(date('Y-m-d H:i:s'));
        $difference = $current_date->diff($date);
        // return "$difference->y years, $difference->m months, $difference->d days, $difference->h ore, $difference->i minuti, $difference->s secondi";

        if ($difference->y == 0) {
            if ($difference->m == 0) {
                if ($difference->d == 0) {
                    if ($difference->h == 0) {
                        if ($difference->i == 0) {
                            if ($difference->s == 1) {
                                return '1 secondo';
                            } else {
                                return $difference->s . ' secondi';
                            }
                        } else {
                            if ($difference->i == 1) {
                                return '1 minuto';
                            } else {
                                return $difference->i . ' minuti';
                            }
                        }
                    } else {
                        if ($difference->h == 1) {
                            return '1 ora';
                        } else {
                            return $difference->h . ' ore';
                        }
                    }
                } else {
                    if ($difference->d == 1) {
                        return '1 giorno';
                    } else {
                        return $difference->d . ' giorni';
                    }
                }
            } else {
                if ($difference->m == 1) {
                    return '1 mese';
                } else {
                    return $difference->m . ' mesi';
                }
            }
        } else {
            if ($difference->y == 1) {
                return '1 anno';
            } else {
                return $difference->y . ' anni';
            }
        }
    }




    public static function setDay($date)
    {
        $dateSplit = explode('/', $date);

        $mounths = ['Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno','Luglio','Agosto','Settembre','Ottobre','Novembre','Dicembre'];

        return $dateSplit[0].' '.$mounths[(int)$dateSplit[1]-1].' '.$dateSplit[2];
    }



}
