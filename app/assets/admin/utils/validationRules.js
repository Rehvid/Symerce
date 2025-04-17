export const validationRules = {
    required: (message = 'To pole jest wymagane') => ({
        required: message,
    }),
    minLength: (value, message = `To pole musi mieć co najmniej ${value} znaki`) => ({
        minLength: {
            value: value,
            message: message,
        },
    }),
    password: () => ({
        pattern: {
            value: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]).{8,}$/,
            message: 'Hasło musi mieć co najmniej 8 znaków, zawierać małą i wielką literę, cyfrę oraz znak specjalny.',
        },
    }),
    min: (value, message = `To pole nie może mieć mniejszej wartości niż ${value}`) => ({
        min: {
            value: value,
            message: message,
        },
    }),
    max: (value, message = `To pole nie może mieć większej wartości niż ${value}`) => ({
        max: {
            value: value,
            message: message,
        },
    }),
    numeric: (maxDecimalPlaces) => ({
        pattern: {
            value: new RegExp(`^\\d+([,.]\\d{1,${maxDecimalPlaces}})?$`),
            message: `Proszę podać liczbę z maksymalnie ${maxDecimalPlaces} miejscami po przecinku. Dozwolone separatory dziesiętne to kropka (.) lub przecinek (,).`,
        },
    }),
};
