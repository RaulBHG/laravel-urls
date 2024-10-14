<?php

namespace Src\v1\Infrastructure\Services;

use Exception;
use Illuminate\Support\Facades\Log;

class ParenthesesProblemService
{
	const parenthesesKeys = [
		'(' => ')',
		'{' => '}',
		'[' => ']',
	];

	public function solveParenthesesProblem(string $token): bool
	{
		try {

			$arrayToken = str_split(string: trim($token)) ?? [];

			$index = 0;
			while ($index < count($arrayToken)) {
				$character = $arrayToken[$index];
				$index = $this->searchCloseParentheses(index: $index, arrayToken: $arrayToken, character: $character);
			}

			return true;

		} catch (Exception $e) {
			Log::info($e->getMessage());
			return false;
		}
	}

	private function searchCloseParentheses(
		int $index,
		array $arrayToken,
		string $character
	): int {

		$validCharacters = ['(', ')', '{', '}', '[', ']'];
		if (!in_array($character, $validCharacters)) {
			throw new Exception('Invalid character');
		}

		$closeParentheses = self::parenthesesKeys[$character] ?? null;
		$nextCharacter = $arrayToken[$index + 1] ?? null;
		Log::info('searchCloseParentheses', ['index' => $index, 'character' => $character, 'foundCharacter' => $nextCharacter]);

		if ($nextCharacter === null || $closeParentheses === null) {

			throw new Exception('Parentheses not closed: ' . $character);

		} elseif ($nextCharacter === $closeParentheses) {

			return $index + 2;

		}

		$index = $this->searchCloseParentheses(
			index: $index + 1,
			arrayToken: $arrayToken,
			character: $nextCharacter
		);
		if($index >= count($arrayToken)) {
			throw new Exception('Parentheses not closed: ' . $character);
		}

		return $index + 1;
	}
}
