<?php

namespace App\Helpers;

abstract class Helper
{
    /**
     * Helper with CPF mask
     * @param string $cpf
     * @return string
     */
    public static function maskCPF($cpf)
    {
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);
        if (strlen($cpf) != 11) {
            return false;
        }
        $mask = "%s%s%s.%s%s%s.%s%s%s-%s%s";
        return sprintf($mask, ...str_split($cpf));
    }

    public static function clearMaskCPF($cpf)
    {
        return preg_replace('/[^0-9]/is', '', $cpf);
    }

    /**
     * Helper with CNPJ mask
     * @param string $cnpj
     * @return string
     */
    public static function maskCNPJ($cnpj)
    {
        $cnpj = preg_replace('/[^0-9]/is', '', $cnpj);
        if (strlen($cnpj) != 14) {
            return false;
        }
        $mask = "%s%s.%s%s%s.%s%s%s/%s%s%s%s-%s%s";
        return sprintf($mask, ...str_split($cnpj));
    }

    public static function clearMaskCNPJ($cnpj)
    {
        return preg_replace('/[^0-9]/is', '', $cnpj);
    }

    /**
     * Helper with phone mask
     * @param string $phone
     * @return string
     */
    public static function maskPhone($phone)
    {
        $phone = preg_replace('/[^0-9]/is', '', $phone);
        if (strlen($phone) == 10) {
            $mask = "(%s%s) %s%s%s%s-%s%s%s%s";
        } elseif (strlen($phone) == 11) {
            $mask = "(%s%s) %s%s%s%s%s-%s%s%s%s";
        } else {
            return false;
        }
        return sprintf($mask, ...str_split($phone));
    }

    public static function clearMaskPhone($phone)
    {
        return preg_replace('/[^0-9]/is', '', $phone);
    }

    /**
     * Helper with money mask (BRL)
     * @param string $money
     * @return string
     */
    public static function maskMoney($money)
    {
        return 'R$ ' . number_format($money, 2, ',', '.');
    }

    public static function clearMaskMoney($money)
    {
        $floatMoney = (float) str_replace(',', '.', str_replace('R$', '', str_replace(' ', '', $money)));
        return sprintf("%.2f", $floatMoney);
    }

    /**
     * Helper with date mask
     * @param string $date
     * @return string
     */
    public static function maskDate($date)
    {
        return date('d/m/Y', strtotime($date));
    }
}
