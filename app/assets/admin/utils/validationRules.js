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
};
