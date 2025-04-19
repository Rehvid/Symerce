import React from 'react';
import { useForm } from 'react-hook-form';
import { createApiConfig } from '@/shared/api/ApiConfig';
import { useUser } from '@/admin/hooks/useUser';
import { ALERT_TYPES } from '@/admin/constants/alertConstants';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';
import { useCreateNotification } from '@/admin/hooks/useCreateNotification';
import ApiForm from '@/admin/components/form/ApiForm';
import FormLayout from '@/admin/layouts/FormLayout';
import ProfilePersonalFormMainColumn from '@/admin/features/profile/components/partials/ProfilePersonalFormMainColumn';
import { useParams } from 'react-router-dom';

const ProfilePersonalForm = () => {
    const params = useParams();
    const { user, setUser } = useUser();
    const { addNotification } = useCreateNotification();
    const {
        register,
        handleSubmit,
        setError,
        setValue,
        formState: { errors: fieldErrors },
    } = useForm({
        mode: 'onBlur',
        defaultValues: {
            email: user.email,
            firstname: user.firstname,
            surname: user.surname,
            id: user.id,
        },
    });

    const apiRequestCallbacks = {
        onSuccess: ({ data, message }) => {
            const { user: currentUser } = data;
            setUser((prev) => ({
                ...prev,
                ...currentUser,
            }));
            addNotification(message, ALERT_TYPES.SUCCESS);
        },
    };

    return (
        <>
            <ApiForm
                apiConfig={createApiConfig(`admin/profiles/${user.id}/personal`, HTTP_METHODS.PUT)}
                handleSubmit={handleSubmit}
                setError={setError}
                apiRequestCallbacks={apiRequestCallbacks}
            >
                <FormLayout
                    mainColumn={
                        <ProfilePersonalFormMainColumn
                            setValue={setValue}
                            setUser={setUser}
                            register={register}
                            fieldErrors={fieldErrors}
                            user={user}
                        />
                    }
                />
            </ApiForm>
        </>
    );
};

export default ProfilePersonalForm;
