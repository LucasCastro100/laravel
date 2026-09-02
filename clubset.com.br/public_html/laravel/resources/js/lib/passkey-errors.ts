const PASSKEY_ERROR_MESSAGES: Record<string, string> = {
    'The passkey operation was cancelled.':
        'Você cancelou o login por chave de acesso.',
    'The passkey operation was not supported.':
        'A chave de acesso não é suportada neste navegador.',
    'The passkey operation failed because this passkey already exists on this device.':
        'Esta chave de acesso já existe neste dispositivo.',
    'The passkey operation failed because the current domain is not registered.':
        'O domínio atual não está registrado para usar chaves de acesso.',
    'The passkey operation failed for the following reason:':
        'A operação de chave de acesso falhou pelo seguinte motivo:',
};

export function translatePasskeyError(
    message: string | null | undefined,
): string | undefined {
    if (!message) {
        return undefined;
    }

    return PASSKEY_ERROR_MESSAGES[message] ?? message;
}
