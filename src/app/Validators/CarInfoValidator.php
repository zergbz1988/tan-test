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
use TanTest\Foundation\Validator;

class CarInfoValidator extends Validator
{
    /**
     * @return bool
     */
    public function validate(): bool
    {
        $params = [
            'name' => [
                'value' => $this->query->get('name'),
                'constrains' => [
                    new NotBlank(),
                    new Type('string'),
                    new Length([
                        'min' => 2,
                        'max' => 255
                    ])
                ]
            ],
            'address' => [
                'value' => $this->query->get('address'),
                'constrains' => [
                    new NotBlank(),
                    new Type('string'),
                    new Length([
                        'min' => 5,
                        'max' => 255
                    ])
                ]
            ],
            'phone' => [
                'value' => $this->query->getInt('phone'),
                'constrains' => [
                    new NotBlank(),
                    new Type('integer'),
                    new Length([
                        'min' => 7,
                        'max' => 11
                    ])
                ]
            ],
            'make' => [
                'value' => $this->query->get('make'),
                'constrains' => [
                    new NotBlank(),
                    new Type('string'),
                    new Length([
                        'min' => 3,
                        'max' => 128
                    ])
                ]
            ],
            'model' => [
                'value' => $this->query->get('model'),
                'constrains' => [
                    new NotBlank(),
                    new Type('string'),
                    new Length([
                        'min' => 1,
                        'max' => 128
                    ])
                ]
            ],
            'componentry' => [
                'value' => $this->query->get('componentry'),
                'constrains' => [
                    new NotBlank(),
                    new Type('string'),
                    new Length([
                        'min' => 3,
                        'max' => 1000
                    ])
                ]
            ],
        ];

        foreach ($params as $param => $data) {
            $this->addErrors($param, $this->validator->validate($data['value'], $data['constrains']));
        }

        if (count($this->errors()) > 0) {
            return false;
        }

        return true;
    }
}