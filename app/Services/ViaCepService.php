<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ViaCepService
{
    private const BASE_URL = 'https://viacep.com.br/ws';

    private const TIMEOUT = 10;

    public function buscarBairroPorCep(string $cep): array
    {
        $cep = $this->sanitizeCep($cep);

        if (!$this->validarFormatoCep($cep)) {
            return ['success' => false, 'message' => 'CEP inválido.'];
        }

        try {
            $response = Http::timeout(self::TIMEOUT)
                ->get(self::BASE_URL . '/' . $cep . '/json/');

            if ($response->failed()) {
                return ['success' => false, 'message' => 'Não foi possível consultar o CEP. Tente novamente.'];
            }

            $data = $response->json();

            if (isset($data['erro']) && $data['erro'] === true) {
                return ['success' => false, 'message' => 'CEP inexistente.'];
            }

            $bairro = $data['bairro'] ?? '';

            if (empty($bairro)) {
                return ['success' => false, 'message' => 'Bairro não encontrado para este CEP.'];
            }

            return [
                'success' => true,
                'bairro' => $bairro,
                'cep' => $cep,
            ];
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            return ['success' => false, 'message' => 'API de CEP indisponível. Tente novamente mais tarde.'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Erro ao consultar CEP. Tente novamente.'];
        }
    }

    private function sanitizeCep(string $cep): string
    {
        return preg_replace('/\D/', '', $cep);
    }

    private function validarFormatoCep(string $cep): bool
    {
        return strlen($cep) === 8 && ctype_digit($cep);
    }
}
