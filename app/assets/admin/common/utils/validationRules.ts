type ValidationRule = {
    required?: string;
    minLength?: { value: number; message: string };
    pattern?: { value: RegExp; message: string };
    min?: { value: number; message: string };
    max?: { value: number; message: string };
};

export const validationRules = {
    required: (message = 'To pole jest wymagane'): ValidationRule => ({
    required: message,
}),

    minLength: (value: number, message = `To pole musi mieć co najmniej ${value} znaki`): ValidationRule => ({
    minLength: {
        value,
        message,
    },
}),

    password: (): ValidationRule => ({
    pattern: {
        value: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\\[\]{};':"\\|,.<>/?]).{8,}$/,
        message: 'Hasło musi mieć co najmniej 8 znaków, zawierać małą i wielką literę, cyfrę oraz znak specjalny.',
    },
}),

    min: (value: number, message = `To pole nie może mieć mniejszej wartości niż ${value}`): ValidationRule => ({
    min: {
        value,
        message,
    },
}),

    max: (value: number, message = `To pole nie może mieć większej wartości niż ${value}`): ValidationRule => ({
    max: {
        value,
        message,
    },
}),

    numeric: (maxDecimalPlaces: number): ValidationRule => ({
    pattern: {
        value: new RegExp(`^\\d+([,.]\\d{1,${maxDecimalPlaces}})?$`),
        message: `Proszę podać liczbę z maksymalnie ${maxDecimalPlaces} miejscami po przecinku. Dozwolone separatory dziesiętne to kropka (.) lub przecinek (,).`,
    },
}),
};
