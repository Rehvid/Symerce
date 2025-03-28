import {useEffect} from "react";

export const useValidationErrors = (validationErrors, setError) => {
    useEffect(() => {
        if (validationErrors && Object.keys(validationErrors).length > 0) {
            Object.entries(validationErrors).forEach(([key, value]) => {
                if (value?.message) {
                    setError(key, { type: "custom", message: value.message });
                }
            });
        }
    }, [validationErrors, setError]);
};
