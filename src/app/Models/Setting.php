<?php

namespace Backpack\Settings\app\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Setting extends Model
{
    use CrudTrait;

    protected $table = 'settings';
    protected $fillable = ['value'];

    public function getValueAttribute()
    {
        $decoded = json_decode($this->attributes['value']);
        $field = json_decode($this->attributes['field']);

        if ($field->type == 'select2_multiple' && is_array($decoded)) {
            $return = new Collection();
            foreach ($decoded as $value) {
                $model = $field->model::find($value);
                if ($model) {
                    $return->push($model);
                }

            }

            return $return;
        }

        return new Collection();
    }
}
