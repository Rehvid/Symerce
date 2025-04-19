export const validationRules = {
    required: (message = 'To pole jest wymagane') => ({
        required: message,
    }),
    minLength: (value, message = `To pole musi mieć co najmniej ${value} znaki`) => ({
        minLength: {
            value,
            message,
        },
    }),
    password: () => ({
        pattern: {
            value: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\\[\]{};':"\\|,.<>/?]).{8,}$/,
            message: 'Hasło musi mieć co najmniej 8 znaków, zawierać małą i wielką literę, cyfrę oraz znak specjalny.',
        },
    }),
    min: (value, message = `To pole nie może mieć mniejszej wartości niż ${value}`) => ({
        min: {
            value,
            message,
        },
    }),
    max: (value, message = `To pole nie może mieć większej wartości niż ${value}`) => ({
        max: {
            value,
            message,
        },
    }),
    numeric: (maxDecimalPlaces) => ({
        pattern: {
            value: `^\\d+([,.]\\d{1,${maxDecimalPlaces}})?$`,
            message: `Proszę podać liczbę z maksymalnie ${maxDecimalPlaces} miejscami po przecinku. Dozwolone separatory dziesiętne to kropka (.) lub przecinek (,).`,
        },
    }),
};
