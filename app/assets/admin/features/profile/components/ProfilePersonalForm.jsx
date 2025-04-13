import React, { useState } from 'react';
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
import Dropzone from '@/admin/components/form/dropzone/Dropzone';
import ModalHeader from '@/admin/components/modal/ModalHeader';
import ModalBody from '@/admin/components/modal/ModalBody';
import DropzoneImagePreview from '@/admin/components/form/dropzone/DropzoneImagePreview';
import { useDropzoneLogic } from '@/admin/hooks/useDropzoneLogic';
import { normalizeFiles } from '@/admin/utils/helper';
import DropzonePreviewActions from '@/admin/components/form/dropzone/DropzonePreviewActions';

const ProfilePersonalForm = () => {
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
    const [userAvatar, setUserAvatar] = useState(normalizeFiles(user?.avatar));

    const setDropzoneValue = (avatar) => {
        setValue('avatar', avatar);
        setUserAvatar(avatar);
    };

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

    const { onDrop, errors, removeFile } = useDropzoneLogic(
        setDropzoneValue,
        (message) => {
            addNotification(message, ALERT_TYPES.SUCCESS);
            setUser((prev) => ({
                ...prev,
                avatar: null,
            }));
        },
        userAvatar,
    );

    const renderModal = (file) => (
        <>
            <ModalHeader title={file.name} />
            <ModalBody>
                <div>
                    <img src={file.preview} alt={file.name} />
                </div>
            </ModalBody>
        </>
    );

    return (
        <>
            <h1 className="text-2xl font-bold mb-6">Personal Information</h1>
            <AppForm
                apiConfig={createApiConfig(`admin/profiles/${user.id}/personal`, HTTP_METHODS.PUT)}
                handleSubmit={handleSubmit}
                setError={setError}
                apiRequestCallbacks={apiRequestCallbacks}
            >
                <div className="flex flex-col w-full gap-[40px]">
                    <div className="flex flex-col gap-2">
                        <h1 className="mb-2 flex flex-col gap-2 text-gray-500">
                            <span className="flex items-center">Avatar </span>
                        </h1>
                        <Dropzone
                            onDrop={onDrop}
                            errors={errors}
                            variant="avatar"
                            containerClasses="relative h-40 w-40"
                        >
                            {userAvatar.length > 0 &&
                              userAvatar.map((file, key) => (
                                <div className="absolute flex top-0 h-full w-full rounded-full" key={key}>
                                    <img
                                      className="rounded-full mx-auto object-cover"
                                      src={file.preview}
                                      alt={file.name}
                                    />
                                    <div className="absolute rounded-full transition-all w-full h-full inset-0 flex items-center justify-center gap-3 hover:backdrop-blur-xl">
                                        <DropzonePreviewActions
                                          renderModal={renderModal}
                                          removeFile={removeFile}
                                          file={file}
                                        />
                                    </div>
                                </div>
                              ))}
                        </Dropzone>
                    </div>

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
