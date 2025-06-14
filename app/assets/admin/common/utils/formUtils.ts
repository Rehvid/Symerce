import { ValidationRule } from '@admin/common/utils/validationRules';


type FieldErrors = Record<string, any>;

export const hasAnyFieldError = (errors: FieldErrors, fields: string[]): boolean => {
    return fields.some((field) => !!errors?.[field]);
};


export const createConditionalValidator = (
    ...rules: ValidationRule[]
): ((value: any) => true | string) => (value) => {
    if (value === null || value === undefined) return true;
    if (typeof value === 'string' && value.trim() === '') return true;

    for (const rule of rules) {
        if (rule.minLength && value.length < rule.minLength.value) {
            return rule.minLength.message;
        }

        if (rule.maxLength && value.length > rule.maxLength.value) {
            return rule.maxLength.message;
        }

        if (rule.pattern && !rule.pattern.value.test(value)) {
            return rule.pattern.message;
        }

        if (rule.min) {
            const num = typeof value === 'number' ? value : parseFloat(value);
            if (!isNaN(num) && num < rule.min.value) return rule.min.message;
        }

        if (rule.max) {
            const num = typeof value === 'number' ? value : parseFloat(value);
            if (!isNaN(num) && num > rule.max.value) return rule.max.message;
        }
    }

    return true;
};
