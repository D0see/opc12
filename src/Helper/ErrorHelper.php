<?php

use Symfony\Component\Validator\ConstraintViolationListInterface;

class ErrorHelper {

    public static function spreadContraintViolationsMessages(
        ConstraintViolationListInterface $errorList,
        string $separator = ', '
    ) {
        $result = array_reduce(
            callback: function($acc, $error) use ($separator) {
                $acc .= $error->getMessage() . $separator;
                return $acc;
            },
            initial: '',
            array: [...$errorList]
        );

        return substr($result, 0, strlen($result) - strlen($separator));
    }
}