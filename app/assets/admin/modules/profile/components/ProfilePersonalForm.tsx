import { useForm } from 'react-hook-form';
import { createApiConfig } from '@/shared/api/ApiConfig';
import { useUser } from '@admin/common/context/UserContext';
import { useNotification } from '@admin/common/context/NotificationContext';
import ApiForm from '@/admin/components/form/ApiForm';
import FormApiLayout from '@admin/layouts/FormApiLayout';
import React from 'react';
import { ProfilePersonalFormData } from '@admin/modules/profile/interfaces/ProfilePersonalFormData';
import { NotificationType } from '@admin/common/enums/notificationTypeEnums';
import ProfilePersonalFormMainColumn from '@admin/modules/profile/components/ProfilePersonalFormMainColumn';


const ProfilePersonalForm: React.FC = () => {
    const { user, setUser } = useUser();
    const { addNotification } = useNotification();
    const {
        register,
        handleSubmit,
        setError,
        setValue,
        formState: { errors: fieldErrors },
    } = useForm<ProfilePersonalFormData>({
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
            addNotification(message, NotificationType.SUCCESS);
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
                <FormApiLayout>
                    <ProfilePersonalFormMainColumn
                        setValue={setValue}
                        setUser={setUser}
                        register={register}
                        fieldErrors={fieldErrors}
                        user={user}
                    />
                </FormApiLayout>
            </ApiForm>
        </>
    );
};

export default ProfilePersonalForm;
