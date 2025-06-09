import { useState } from 'react';
import { FormDataInterface } from '@admin/common/interfaces/FormDataInterface';
import { HttpMethod } from '@admin/common/enums/httpEnums';
import { UseFormSetValue, Path, PathValue } from 'react-hook-form';
import { FieldModifier } from '@admin/common/types/fieldModifier';
import { UseFormInitializerReturn } from '@admin/common/hooks/form/useFormInitializer.types';
import { FormContextInterface } from '@admin/common/interfaces/FormContextInterface';
import { useAdminApi } from '@admin/common/context/AdminApiContext';


const useFormInitializer = <T extends FormDataInterface = FormDataInterface>(): UseFormInitializerReturn<T>  => {
    const { handleApiRequest } = useAdminApi();

  const [isFormInitialize, setIsFormInitialize] = useState<boolean>(true);
  const [formData, setFormData] = useState<T>({} as T);
  const [formContext, setFormContext] = useState<FormContextInterface>();

    const getFormData  = async (
        endpoint: string,
        setValue: UseFormSetValue<T>,
        formFieldNames?: (keyof T)[],
        fieldModifiers?: FieldModifier<T>[],
    ) => {
        setIsFormInitialize(false);

        await handleApiRequest(HttpMethod.GET, endpoint, {
            onSuccess: (data) => {
                if (!data) {
                    setIsFormInitialize(true);
                    return;
                }

                const { formData: formFieldsData, formContext } = data as any;

                setFormContext(formContext);
                handleSuccessGetFormData(formFieldsData, formFieldNames, fieldModifiers, setValue);
                setIsFormInitialize(true);
            },
            onError: () => {
                setIsFormInitialize(true);
            },
            onNetworkError: () => {
                setIsFormInitialize(true);
            },
        });
    };

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
                    setValue(
                        fieldName as unknown as Path<T>,
                        value as PathValue<T, Path<T>>
                    );
                }
            }
        });
    };

  return { isFormInitialize, formData, formContext, getFormData }
}

export default useFormInitializer;
