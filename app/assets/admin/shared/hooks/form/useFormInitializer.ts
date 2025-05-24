import { useState } from 'react';
import { FormDataInterface } from '@admin/shared/interfaces/FormDataInterface';
import { useApi } from '@admin/hooks/useApi';
import { HttpMethod } from '@admin/shared/enums/httpEnums';
import { createApiConfig } from '@shared/api/ApiConfig';
import { UseFormSetValue } from 'react-hook-form';
import { FieldModifier } from '@admin/shared/types/fieldModifier';
import { UseFormInitializerReturn } from '@admin/shared/hooks/form/useFormInitializer.types';


const useFormInitializer =  <T extends FormDataInterface = FormDataInterface>(): UseFormInitializerReturn<T>  => {
  const { handleApiRequest } = useApi();

  const [isFormInitialize, setIsFormInitialize] = useState<boolean>(true);
  const [formData, setFormData] = useState<T>({} as T);

  const getFormData = (
    endpoint: string,
    setValue: UseFormSetValue<T>,
    formFieldNames?: (keyof T)[],
    fieldModifiers?: FieldModifier<T>[],
  ) => {
    setIsFormInitialize(false);

    handleApiRequest(createApiConfig(endpoint, HttpMethod.GET), {
      onSuccess: ({ data }) => {
        const { formData: formFieldsData } = data;
        handleSuccessGetFormData(formFieldsData, formFieldNames, fieldModifiers, setValue);
        setIsFormInitialize(true);
      },
    });
  }

  const handleSuccessGetFormData = (
    formFieldsData: T,
    formFieldNames?: (keyof T)[],
    fieldModifiers?: FieldModifier<T>[],
    setValue?: UseFormSetValue<T>,
  ) => {
    setFormData(formFieldsData);

    formFieldNames?.forEach((fieldName) => {
      if (formFieldsData[fieldName] !== undefined) {
        let value = formFieldsData[fieldName];

        const modifier = fieldModifiers?.find((mod) => mod.fieldName === fieldName);
        if (modifier) {
          value = modifier.action(value);
        }

        if (value !== undefined && setValue) {
          setValue(fieldName, value);
        }
      }
    });
  }

  return { isFormInitialize, formData, getFormData }
}

export default useFormInitializer;
