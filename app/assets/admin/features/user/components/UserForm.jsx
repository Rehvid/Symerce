import ApiForm from '@/admin/components/form/ApiForm';
import { createApiConfig } from '@/shared/api/ApiConfig';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';
import React, { useEffect, useState } from 'react';
import { NOTIFICATION_TYPES } from '@/admin/constants/notificationConstants';
import { useNavigate } from 'react-router-dom';
import { useApi } from '@/admin/hooks/useApi';
import { useCreateNotification } from '@/admin/hooks/useCreateNotification';
import { useForm } from 'react-hook-form';
import FormLayout from '@/admin/layouts/FormLayout';
import UserFormMainColumn from '@/admin/features/user/components/UserFormMainColumn';
import UserFormSideColumn from '@/admin/features/user/components/UserFormSideColumn';

const UserForm = ({params}) => {
  const {
    register,
    handleSubmit,
    setValue,
    setError,
    control,
    formState: { errors: fieldErrors },
  } = useForm({
    mode: 'onBlur',
    defaultValues: {
      id: Number(params.id) ?? null,
    },
  });
  const navigate = useNavigate();
  const { handleApiRequest, isRequestFinished } = useApi();
  const { addNotification } = useCreateNotification();
  const [userData, setUserData] = useState({});


  useEffect(() => {
    const endpoint = params.id ? `admin/users/${params.id}/form-data` : 'admin/categories/form-data';
    const createConfig = createApiConfig(endpoint, HTTP_METHODS.GET);
    handleApiRequest(createConfig, {
      onSuccess: ({ data }) => {
        const { formData } = data;
        if (formData) {
          setUserData(formData);
          setValue('firstname', formData.firstname);
          setValue('surname', formData.surname);
          setValue('email', formData.email);
          setValue('roles', formData.roles);
        }
      },
    });
  }, []);


  const apiRequestCallbacks = {
    onSuccess: ({ data, message }) => {
      addNotification(message, NOTIFICATION_TYPES.SUCCESS);
      if (!params.id && data.id) {
        navigate(`/admin/users/${data.id}/edit`, { replace: true });
      }
      navigate(`/admin/users`, { replace: true });
    },
  };

  const apiConfig = params.id
    ? createApiConfig(`admin/users/${params.id}`, HTTP_METHODS.PUT)
    : createApiConfig('admin/users', HTTP_METHODS.POST);


    return (
      <ApiForm
        apiConfig={apiConfig}
        handleSubmit={handleSubmit}
        setError={setError}
        apiRequestCallbacks={apiRequestCallbacks}
      >
        <FormLayout
          mainColumn={
            <UserFormMainColumn
              register={register}
              fieldErrors={fieldErrors}
              control={control}
              params={params}
            />
          }
          sideColumn={
            <UserFormSideColumn
              register={register}
              setValue={setValue}
              userData={userData}
              setUserData={setUserData}
            />
          }
        />
      </ApiForm>
    );
}

export default UserForm;
