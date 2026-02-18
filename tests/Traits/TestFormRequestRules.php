<?php

namespace Tests\Traits;

use Illuminate\Support\Str;

trait TestFormRequestRules
{
    public function getUpdateRequestRules()
    {
        $record = $this->model::factory()->create();
        $payload = $this->getPayload();
        $response = $this->sendUpdateRequest($record->id, $payload);

        return $this->updateRequest::createFrom($response->getRequest())->rules();
    }

    public function getStoreRequestRules()
    {
        $payload = $this->getPayload();
        $response = $this->sendStoreRequest($payload);

        return $this->storeRequest::createFrom($response->getRequest())->rules();
    }

    public function test_update_method_check_rules()
    {
        $record = $this->createRecord();

        foreach ($this->getUpdateRequestRules() as $property => $rules) {
            $payload = $this->getPayload();

            // required
            if (in_array('required', $rules)) {
                unset($payload[$property]);

                $this->sendUpdateRequest($record->id, $payload)
                    ->assertRedirectBack()
                    ->assertSessionHasErrors([$property]);
            }

            // min
            if (count($greps = preg_grep("/^min:[0-9]*$/", $rules))) {
                $greps = array_values($greps);
                preg_match("/[0-9]*$/", array_values($greps)[0], $min);
                $min = (int) $min[0];

                if ($min > 0) {
                    $payload[$property] = Str::random($min - 1);

                    $this->sendUpdateRequest($record->id, $payload)
                        ->assertRedirectBack()
                        ->assertSessionHasErrors([$property]);
                }
            }

            // max
            if (count($greps = preg_grep("/^max:[0-9]*$/", $rules))) {
                $greps = array_values($greps);
                preg_match("/[0-9]*$/", array_values($greps)[0], $max);
                $max = (int) $max[0];

                $payload[$property] = Str::random($max + 1);

                $this->sendUpdateRequest($record->id, $payload)
                    ->assertRedirectBack()
                    ->assertSessionHasErrors([$property]);
            }

            // unique
            if (count($greps = preg_grep("/^unique:.*$/", $rules))) {
                $greps = array_values($greps);
                preg_match("/(?<=unique:).*/", array_values($greps)[0], $unique);
                $uniqueParams = explode(',', $unique[0]);

                $model = $uniqueParams[0];
                $column = $uniqueParams[1];

                $other_record = $model::factory()->create();
                $payload[$column] = $other_record->$property;

                $this->sendUpdateRequest($record->id, $payload)
                    ->assertRedirectBack()
                    ->assertSessionHasErrors([$property]);
            }
        }
    }

    public function test_store_method_check_rules()
    {
        foreach ($this->getStoreRequestRules() as $property => $rules) {
            $payload = $this->getPayload();

            // required
            if (in_array('required', $rules)) {
                unset($payload[$property]);

                $this->sendStoreRequest($payload)
                    ->assertRedirectBack()
                    ->assertSessionHasErrors([$property]);
            }

            // min
            if (count($greps = preg_grep("/^min:[0-9]*$/", $rules))) {
                $greps = array_values($greps);
                preg_match("/[0-9]*$/", array_values($greps)[0], $min);
                $min = (int) $min[0];

                if ($min > 0) {
                    $payload[$property] = Str::random($min - 1);

                    $this->sendStoreRequest($payload)
                        ->assertRedirectBack()
                        ->assertSessionHasErrors([$property]);
                }
            }

            // max
            if (count($greps = preg_grep("/^max:[0-9]*$/", $rules))) {
                $greps = array_values($greps);
                preg_match("/[0-9]*$/", array_values($greps)[0], $max);
                $max = (int) $max[0];

                $payload[$property] = Str::random($max + 1);

                $this->sendStoreRequest($payload)
                    ->assertRedirectBack()
                    ->assertSessionHasErrors([$property]);
            }

            // unique
            if (count($greps = preg_grep("/^unique:.*$/", $rules))) {
                $greps = array_values($greps);
                preg_match("/(?<=unique:).*/", array_values($greps)[0], $unique);
                $uniqueParams = explode(',', $unique[0]);

                $model = $uniqueParams[0];
                $column = $uniqueParams[1];

                $other_record = $model::factory()->create();
                $payload[$column] = $other_record->$property;

                $this->sendStoreRequest($payload)
                    ->assertRedirectBack()
                    ->assertSessionHasErrors([$property]);
            }
        }
    }
}
