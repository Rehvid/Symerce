import React from 'react';
import { useForm } from 'react-hook-form';
import { validationRules } from '@/admin/utils/validationRules';
import UserIcon from '@/images/icons/user.svg';
import { createApiConfig } from '@/shared/api/ApiConfig';
import AppInput from '@/admin/components/form/AppInput';
import { useUser } from '@/admin/hooks/useUser';
import AppInputEmail from '@/admin/components/form/AppInputEmail';
import { ALERT_TYPES } from '@/admin/constants/alertConstants';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';
import { useCreateNotification } from '@/admin/hooks/useCreateNotification';
import AppForm from '@/admin/components/form/AppForm';
import AppFormFixedButton from '@/admin/components/form/AppFormFixedButton';

const ProfilePersonalForm = () => {
    const { user, setUser } = useUser();
    const {
        register,
        handleSubmit,
        setError,
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

    const { addNotification } = useCreateNotification();
    const apiRequestCallbacks = {
        onSuccess: (data) => {
            const { user: currentUser } = data;
            setUser((prev) => ({
                ...prev,
                ...currentUser,
            }));
            addNotification('Udało się zapisać dane!', ALERT_TYPES.SUCCESS);
        },
    };

    return (
        <>
            <h1 className="text-2xl font-bold mb-6">Personal Information</h1>
            <AppForm
                apiConfig={createApiConfig(`admin/profile/${user.id}/update-personal`, HTTP_METHODS.PUT)}
                handleSubmit={handleSubmit}
                setError={setError}
                apiRequestCallbacks={apiRequestCallbacks}
            >
                <div className="flex flex-col w-full gap-[40px]">
                    <AppInput
                        {...register('firstname', {
                            ...validationRules.required(),
                            ...validationRules.minLength(3),
                        })}
                        type="text"
                        id="firstname"
                        label="Imie"
                        hasError={fieldErrors.hasOwnProperty('firstname')}
                        errorMessage={fieldErrors?.firstname?.message}
                        isRequired
                        icon={<UserIcon className="text-gray-500" />}
                    />
                    <AppInput
                        {...register('surname', {
                            ...validationRules.required(),
                            ...validationRules.minLength(2),
                        })}
                        type="text"
                        id="surname"
                        label="Nazwisko"
                        hasError={fieldErrors.hasOwnProperty('surname')}
                        errorMessage={fieldErrors?.surname?.message}
                        isRequired
                        icon={<UserIcon className="text-gray-500" />}
                    />
                    <AppInputEmail
                        hasError={fieldErrors.hasOwnProperty('email')}
                        errorMessage={fieldErrors?.email?.message}
                        {...register('email', {
                            ...validationRules.required(),
                            ...validationRules.minLength(3),
                        })}
                    />
                </div>

                <AppFormFixedButton />
            </AppForm>
        </>
    );
};

export default ProfilePersonalForm;
