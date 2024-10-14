<?php

namespace App\Http\Requests;

use App\Http\Requests\StandarRequestAbstract;

class ShortUrlRequest extends StandarRequestAbstract
{
	public function rules(): array
	{
		return [
			'url' => 'required|string',
		];
	}

	public function messages(): array
	{
		return [
			'url' => 'The return_url is required as string',
		];
	}
}
