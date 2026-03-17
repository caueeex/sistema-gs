<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AuthorizationService
{
    private const URL = 'https://util.devi.tools/api/v2/authorize';

    private const TIMEOUT = 10;

    public function isAuthorized(): array
    {
        try {
            $response = Http::timeout(self::TIMEOUT)->get(self::URL);

            if ($response->failed()) {
                return [
                    'authorized' => false,
                    'message' => 'Serviço de autorização indisponível. Tente novamente mais tarde.',
                ];
            }

            $data = $response->json();
            $status = $data['status'] ?? null;

            if ($status === 'fail') {
                return [
                    'authorized' => false,
                    'message' => 'Operação não autorizada no momento.',
                ];
            }

            return [
                'authorized' => true,
                'message' => null,
            ];
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            return [
                'authorized' => false,
                'message' => 'Não foi possível conectar ao serviço de autorização. Tente novamente.',
            ];
        } catch (\Exception $e) {
            return [
                'authorized' => false,
                'message' => 'Erro ao verificar autorização. Tente novamente mais tarde.',
            ];
        }
    }
}
