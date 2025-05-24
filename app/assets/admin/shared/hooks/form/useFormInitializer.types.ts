import { FormDataInterface } from '@admin/shared/interfaces/FormDataInterface';
import { UseFormSetValue } from 'react-hook-form';
import { FieldModifier } from '@admin/shared/types/fieldModifier';

export type UseFormInitializerReturn<T extends FormDataInterface> = {
  isFormInitialize: boolean;
  formData: T;
  getFormData: (
    endpoint: string,
    setValue: UseFormSetValue<T>,
    formFieldNames?: (keyof T)[],
    fieldModifiers?: FieldModifier<T>[],
  ) => void;
};
