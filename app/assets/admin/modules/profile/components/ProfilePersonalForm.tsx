import { useForm } from 'react-hook-form';
import { useUser } from '@admin/common/context/UserContext';
import { useNotification } from '@admin/common/context/NotificationContext';
import FormApiLayout from '@admin/layouts/FormApiLayout';
import React from 'react';
import { ProfilePersonalFormData } from '@admin/modules/profile/interfaces/ProfilePersonalFormData';
import { NotificationType } from '@admin/common/enums/notificationTypeEnums';
import ProfilePersonalBodyForm from '@admin/modules/profile/components/ProfilePersonalBodyForm';
import FormWrapper from '@admin/common/components/form/FormWrapper';
import { HttpMethod } from '@admin/common/enums/httpEnums';

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
        onSuccess: ({ data, message }: {data: any, message: string}) => {
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
            <FormWrapper
                method={HttpMethod.PUT}
                endpoint={`admin/profiles/${user.id}/personal`}
                handleSubmit={handleSubmit}
                setError={setError}
                apiRequestCallbacks={apiRequestCallbacks}
            >
                <FormApiLayout>
                    <ProfilePersonalBodyForm
                        setValue={setValue}
                        setUser={setUser}
                        register={register}
                        fieldErrors={fieldErrors}
                        user={user}
                    />
                </FormApiLayout>
            </FormWrapper>
        </>
    );
};

export default ProfilePersonalForm;
