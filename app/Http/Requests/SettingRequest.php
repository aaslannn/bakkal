<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SettingRequest extends Request {

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
		return [
            'meta_baslik' => 'required|min:3',
            'meta_aciklama' => 'required|min:3',
            'meta_keywords' => 'required',
            'isim' => 'required',
            'web' => 'required',
            'tel' => 'required|min:5',
            'email' => 'required|min:3|email',
            'featured_count' => 'required|integer|max:40',
            'logo_fontsize' => 'integer|max:60',
		];
	}

    public function attributes()
    {
        return [
            'meta_baslik'   => trans('settings/form.meta_baslik'),
            'meta_aciklama' => trans('settings/form.meta_aciklama'),
            'meta_keywords' => trans('settings/form.meta_keywords'),
            'isim'          => trans('settings/form.isim'),
            'web'           => trans('settings/form.web'),
            'tel'           => trans('settings/form.tel'),
            'email'         => trans('settings/form.email'),
            'featured_count' => trans('settings/form.featured_count'),
            'logo_fontsize' => trans('settings/form.logo_fontsize'),
        ];
    }

}
