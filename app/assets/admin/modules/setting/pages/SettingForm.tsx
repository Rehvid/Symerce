import { Path, useForm } from 'react-hook-form';
import { SettingField, SettingFormData } from '@admin/modules/setting/interfaces/SettingFormData';
import useApiFormSubmit from '@admin/common/hooks/form/useApiFormSubmit';
import useFormInitializer from '@admin/common/hooks/form/useFormInitializer';
import FormSkeleton from '@admin/common/components/skeleton/FormSkeleton';
import FormWrapper from '@admin/common/components/form/FormWrapper';
import FormApiLayout from '@admin/layouts/FormApiLayout';
import { useEffect } from 'react';
import SettingFormBody from '@admin/modules/setting/components/SettingFormBody';
import { FieldModifier } from '@admin/common/types/fieldModifier';

const SettingForm = () => {
    const { getRequestConfig, defaultApiSuccessCallback, entityId, isEditMode } = useApiFormSubmit({
        baseApiUrl: 'admin/settings',
        redirectSuccessUrl: '/admin/settings',
    });
    const requestConfig = getRequestConfig();
  const {
    register,
    handleSubmit,
    setValue,
    setError,
    control,
    watch,
    formState: { errors: fieldErrors },
  } = useForm<SettingFormData>({
    mode: 'onBlur',
  });

  const { isFormInitialize, formData, formContext, getFormData } = useFormInitializer<SettingFormData>();

  useEffect(() => {
    const endpoint = `admin/settings/${entityId}`;
    const formFieldNames = [
      'name',
      'isActive',
      'settingField',
    ] satisfies (keyof SettingFormData)[] ;

    const formFieldModifiers: FieldModifier<SettingFormData>[] = [
      {
        fieldName: 'settingField',
        action: (item: SettingField) => {
          setValue('value' as Path<SettingFormData>, item.value);
          setValue('settingValueType' as Path<SettingFormData>, item.type);
        },
      }
    ]

    getFormData(endpoint, setValue, formFieldNames, formFieldModifiers);
  }, []);

  if (!isFormInitialize) {
    return <FormSkeleton rowsCount={12} />;
  }

  return (
    <FormWrapper
        method={requestConfig.method}
        endpoint={requestConfig.endpoint}
        handleSubmit={handleSubmit}
        setError={setError}
        apiRequestCallbacks={defaultApiSuccessCallback}
    >
      <FormApiLayout pageTitle='Edytuj ustawienie'>
        <SettingFormBody
          register={register}
          control={control}
          fieldErrors={fieldErrors}
          formData={formData}
        />
      </FormApiLayout>
    </FormWrapper>
  );
}

export default SettingForm;
