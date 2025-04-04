import { useEffect, useState } from 'react';

export const useValidationErrors = (setError) => {
    const [validationErrors, setValidationErrors] = useState({});

    useEffect(() => {
        Object.entries(validationErrors).forEach(([key, value]) => {
            if (value?.message) {
                setError(key, { type: 'custom', message: value.message });
            }
        });
    }, [validationErrors, setError]);

    return { setValidationErrors };
};
