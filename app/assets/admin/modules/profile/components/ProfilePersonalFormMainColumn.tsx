import React, { useState } from 'react';
import Heading from '@admin/common/components/Heading';
import Dropzone from '@/admin/components/form/dropzone/Dropzone';

import Input from '@/admin/components/form/controls/Input';
import { validationRules } from '@admin/common/utils/validationRules';
import UserIcon from '@/images/icons/user.svg';
import InputEmail from '@/admin/components/form/controls/InputEmail';
import { normalizeFiles } from '@admin/common/utils/helper';
import { useNotification } from '@admin/common/context/NotificationContext';
import DropzoneThumbnail from '@/admin/components/form/dropzone/DropzoneThumbnail';
import { useDropzoneLogic } from '@admin/common/hooks/form/useDropzoneLogic';
import { NotificationType } from '@admin/common/enums/notificationTypeEnums';

import { FieldErrors, UseFormRegister, UseFormSetValue } from 'react-hook-form';

interface UserAvatarFile {
    id: string | null;
    uuid?: string;
    [key: string]: any;
}

interface User {
    avatar?: UserAvatarFile[] | null;
    [key: string]: any;
}

interface ProfilePersonalFormMainColumnProps {
    setValue: UseFormSetValue<any>;
    setUser: React.Dispatch<React.SetStateAction<User>>;
    register: UseFormRegister<any>;
    fieldErrors: FieldErrors<any>;
    user: User;
}

const ProfilePersonalFormMainColumn: React.FC<ProfilePersonalFormMainColumnProps> = ({
                                                                                         setValue,
                                                                                         setUser,
                                                                                         register,
                                                                                         fieldErrors,
                                                                                         user,
                                                                                     }) => {
    const { addNotification } = useNotification();
    const [userAvatar, setUserAvatar] = useState<UserAvatarFile[]>(normalizeFiles(user?.avatar));

    const setDropzoneValue = (avatar: UserAvatarFile[]) => {
        setValue('avatar', avatar);
        setUserAvatar(avatar);
    };

    const { onDrop, errors, removeFile } = useDropzoneLogic(
        setDropzoneValue,
        (message: string) => {
            addNotification(message, NotificationType.SUCCESS);
            setUser((prev) => ({
                ...prev,
                avatar: null,
            }));
        },
        userAvatar,
    );

    return (
        <>
            <Heading level="h4">
                <span className="flex items-center">Avatar </span>
            </Heading>

            <Dropzone onDrop={onDrop} errors={errors} variant="avatar" containerClasses="relative h-40 w-40">
                {userAvatar.length > 0 &&
                    userAvatar.map((file, key) => (
                        <DropzoneThumbnail file={file} removeFile={removeFile} variant="avatar" key={key} index={key} />
                    ))}
            </Dropzone>

            <Input
                {...register('firstname', {
                    ...validationRules.required(),
                    ...validationRules.minLength(3),
                })}
                type="text"
                id="firstname"
                label="Imie"
                hasError={!!fieldErrors?.firstname}
                errorMessage={fieldErrors?.firstname?.message}
                isRequired
                icon={<UserIcon className="text-gray-500 w-[24px] h-[24px]" />}
            />
            <Input
                {...register('surname', {
                    ...validationRules.required(),
                    ...validationRules.minLength(2),
                })}
                type="text"
                id="surname"
                label="Nazwisko"
                hasError={!!fieldErrors?.surname}
                errorMessage={fieldErrors?.surname?.message}
                isRequired
                icon={<UserIcon className="text-gray-500 w-[24px] h-[24px]" />}
            />
            <InputEmail
                hasError={!!fieldErrors?.email}
                errorMessage={fieldErrors?.email?.message}
                {...register('email', {
                    ...validationRules.required(),
                    ...validationRules.minLength(3),
                })}
            />
        </>
    );
};

export default ProfilePersonalFormMainColumn;
