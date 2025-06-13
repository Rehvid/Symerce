import { useEffect, useState } from 'react';
import { FieldValues, UseFormSetError } from 'react-hook-form';

interface ValidationError {
    message?: string;
    [key: string]: any;
}

type ValidationErrors<T> = {
    [K in keyof T]?: ValidationError;
};

export const useValidationErrors = <T extends FieldValues>(setError: UseFormSetError<T>) => {
    const [validationErrors, setValidationErrors] = useState<ValidationErrors<T>>({});

    useEffect(() => {
        Object.entries(validationErrors).forEach(([key, value]) => {
            if (value?.message) {
                setError(key as keyof T, { type: 'custom', message: value.message! });
            }
        });
    }, [validationErrors, setError]);

    return { setValidationErrors };
};
