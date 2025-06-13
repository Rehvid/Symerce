import React from 'react';
import { DropzoneVariant } from '@admin/common/components/dropzone/Dropzone';
import { validationRules } from '@admin/common/utils/validationRules';
import UserIcon from '@/images/icons/user.svg';
import { useNotification } from '@admin/common/context/NotificationContext';

import { FieldErrors, UseFormRegister, UseFormSetValue } from 'react-hook-form';
import { ProfilePersonalFormData } from '@admin/modules/profile/interfaces/ProfilePersonalFormData';
import InputField from '@admin/common/components/form/input/InputField';
import SingleImageUploader from '@admin/common/components/form/SingleImageUploader';
import { User } from '@admin/common/context/UserContext';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import FormSection from '@admin/common/components/form/FormSection';
import { NotificationType } from '@admin/common/enums/notificationTypeEnums';

interface ProfilePersonalBodyFormProps {
    setValue: UseFormSetValue<ProfilePersonalFormData>;
    setUser: React.Dispatch<React.SetStateAction<User>>;
    register: UseFormRegister<ProfilePersonalFormData>;
    fieldErrors: FieldErrors<ProfilePersonalFormData>;
    user: User;
}

const ProfilePersonalBodyForm: React.FC<ProfilePersonalBodyFormProps> = ({
    setValue,
    setUser,
    register,
    fieldErrors,
    user,
}) => {
    const { addNotification } = useNotification();

    return (
        <FormSection title="Dane osobowe" useToggleContent={false}>
            <SingleImageUploader
                label="Avatar"
                fieldName="avatar"
                setValue={setValue}
                initialValue={user?.avatar}
                variant={DropzoneVariant.Avatar}
                onSuccessRemove={(message: string) => {
                    addNotification(message, NotificationType.SUCCESS);
                    setUser((prev) => ({
                        ...prev,
                        avatar: null,
                    }));
                }}
            />

            <FormGroup label={<InputLabel label="Imie" isRequired={true} />}>
                <InputField
                    {...register('firstname', {
                        ...validationRules.required(),
                        ...validationRules.minLength(2),
                    })}
                    type="text"
                    id="firstname"
                    hasError={!!fieldErrors?.firstname}
                    errorMessage={fieldErrors?.firstname?.message}
                    icon={<UserIcon className="text-gray-500 w-[24px] h-[24px]" />}
                />
            </FormGroup>

            <FormGroup label={<InputLabel label="Nazwisko" isRequired={true} />}>
                <InputField
                    {...register('surname', {
                        ...validationRules.required(),
                        ...validationRules.minLength(2),
                    })}
                    type="text"
                    id="surname"
                    hasError={!!fieldErrors?.surname}
                    errorMessage={fieldErrors?.surname?.message}
                    icon={<UserIcon className="text-gray-500 w-[24px] h-[24px]" />}
                />
            </FormGroup>
            <FormGroup label={<InputLabel label="Email" isRequired={true} />}>
                <InputField
                    hasError={!!fieldErrors?.email}
                    errorMessage={fieldErrors?.email?.message}
                    {...register('email', {
                        ...validationRules.required(),
                        ...validationRules.minLength(3),
                    })}
                />
            </FormGroup>
        </FormSection>
    );
};

export default ProfilePersonalBodyForm;
