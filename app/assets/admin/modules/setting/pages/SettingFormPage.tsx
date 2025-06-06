import { useParams } from 'react-router-dom';
import { useForm } from 'react-hook-form';
import { SettingFormDataInterface } from '@admin/modules/setting/interfaces/SettingFormDataInterface';
import useApiFormSubmit from '@admin/common/hooks/form/useApiFormSubmit';
import useFormInitializer from '@admin/common/hooks/form/useFormInitializer';
import FormSkeleton from '@admin/common/components/skeleton/FormSkeleton';
import FormWrapper from '@admin/common/components/form/FormWrapper';
import FormApiLayout from '@admin/layouts/FormApiLayout';
import { useEffect } from 'react';
import SettingFormBody from '@admin/modules/setting/components/SettingFormBody';
import { SettingInputType } from '@admin/modules/setting/enums/settingInputType';

const SettingFormPage = () => {
  const params = useParams();
  const {
    register,
    handleSubmit,
    setValue,
    setError,
    control,
    watch,
    formState: { errors: fieldErrors },
  } = useForm<SettingFormDataInterface>({
    mode: 'onBlur',
  });

  const baseApiUrl = 'admin/settings';
  const redirectSuccessUrl = '/admin/settings';
  const { getApiConfig, defaultApiSuccessCallback } = useApiFormSubmit(baseApiUrl, redirectSuccessUrl, params);
  const { isFormInitialize, formData, formContext, getFormData } = useFormInitializer<SettingFormDataInterface>();

  useEffect(() => {
    const endpoint = `admin/settings/${params.id}`;
    const formFieldNames = [
      'name',
      'isActive',
      'settingField',
    ];

    const formFieldModifiers = [
      {
        fieldName: 'settingField',
        action: (item: SettingFormDataInterface) => {
          setValue('value', item.value);
          setValue('settingValueType', item.type);
        },
      }
    ]

    getFormData(endpoint, setValue, formFieldNames, formFieldModifiers);
  }, []);

  if (!isFormInitialize) {
    return <FormSkeleton rowsCount={12} />;
  }

  const modifySubmitValues = (values: SettingFormDataInterface) => {
    const data = {...values};
    
    if (formData.settingField.inputType === SettingInputType.SELECT) {
      data.value = values?.value?.value || data.value;
    }

    return data;
  }

  return (
    <FormWrapper
      apiConfig={getApiConfig()}
      handleSubmit={handleSubmit}
      setError={setError}
      apiRequestCallbacks={defaultApiSuccessCallback}
      modifySubmitValues={modifySubmitValues}
    >
      <FormApiLayout pageTitle='Edytuj ustawienie'>
        <SettingFormBody
          register={register}
          control={control}
          watch={watch}
          setValue={setValue}
          fieldErrors={fieldErrors}
          formData={formData}
          formContext={formContext}
        />
      </FormApiLayout>
    </FormWrapper>
  );
}

export default SettingFormPage;
