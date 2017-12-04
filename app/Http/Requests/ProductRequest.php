<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProductRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules =  [
            'title_tr'  => 'required',
            //'code'      => 'unique:products',
            'cat_id'    => 'required|numeric|min:1',
            'price'     => 'required',
            'kdv'       => 'required|numeric|max:100',
            'file'      => 'mimes:pdf,doc,docx',
		];

		/*$images = count($this->input('images') - 1);
        foreach (range(0,$images) as $index) {
            $rules['images.'.$index] => 'image|max:5000';
		}*/
		return $rules;
	}

    public function attributes()
    {
        return [
            'title_tr'     => 'Başlık',
            //'code'      => 'Kod',
            'cat_id'    => 'Kategori',
            'price'     => 'Fiyat',
            'kdv'       => 'KDV',
            'file'      => 'mimes:pdf,doc,docx',
        ];
    }

}
