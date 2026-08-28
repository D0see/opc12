<?php

use Symfony\Component\Validator\ConstraintViolationListInterface;

class ErrorHelper {

    public static function spreadContraintViolationsMessages(ConstraintViolationListInterface $errorList) {
        $result = array_reduce(
            callback: function($acc, $error) {
                $acc .= $error->getMessage() . ', ';
                return $acc;
            },
            initial: '',
            array: [...$errorList]
        );

        return substr($result, 0, strlen($result) -2);
    }
}