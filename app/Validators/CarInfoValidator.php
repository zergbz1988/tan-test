<?php
/**
 * Created by PhpStorm.
 * User: Marat
 * Date: 06.01.2019
 * Time: 19:04
 */

namespace App\Validators;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use TanTest\Http\Request\Validator;

class CarInfoValidator extends Validator
{
    /**
     * @return bool
     */
    public function validate(): bool
    {
        $constrains = [
            'name' => [
                new NotBlank(),
                new Type('string'),
                new Length([
                    'min' => 2,
                    'max' => 255
                ])
            ],
            'address' => [
                new NotBlank(),
                new Type('string'),
                new Length([
                    'min' => 5,
                    'max' => 255
                ])
            ],
            'phone' => [
                new NotBlank(),
                new Type('integer'),
                new Length([
                    'min' => 7,
                    'max' => 11
                ])
            ],
            'make' => [
                new NotBlank(),
                new Type('string'),
                new Length([
                    'min' => 3,
                    'max' => 128
                ])
            ],
            'model' => [
                new NotBlank(),
                new Type('string'),
                new Length([
                    'min' => 1,
                    'max' => 128
                ])
            ],
            'componentry' => [
                new NotBlank(),
                new Type('string'),
                new Length([
                    'min' => 3,
                    'max' => 1000
                ])
            ],
        ];

        foreach ($constrains as $parameter => $constrain) {
            $this->addErrors($parameter, $this->validator->validate($this->query->get($parameter), $constrain));
        }

        if (count($this->errors()) > 0) {
            return false;
        }

        return true;
    }
}