import { FormDataInterface } from '@admin/common/interfaces/FormDataInterface';
import { UseFormSetValue } from 'react-hook-form';
import { FieldModifier } from '@admin/common/types/fieldModifier';
import { FormContextInterface } from '@admin/common/interfaces/FormContextInterface';

export type UseFormInitializerReturn<T extends FormDataInterface> = {
    isFormInitialize: boolean;
    formData: T;
    getFormData: (
        endpoint: string,
        setValue: UseFormSetValue<T>,
        formFieldNames?: (keyof T)[],
        fieldModifiers?: FieldModifier<T>[],
    ) => void;
    formContext: any;
};
