import { useState } from 'react';
import Heading from '@/admin/components/common/Heading';
import Dropzone from '@/admin/components/form/dropzone/Dropzone';
import { useDropzoneLogic } from '@/admin/hooks/useDropzoneLogic';
import { ALERT_TYPES } from '@/admin/constants/alertConstants';
import Input from '@/admin/components/form/controls/Input';
import { validationRules } from '@/admin/utils/validationRules';
import UserIcon from '@/images/icons/user.svg';
import InputEmail from '@/admin/components/form/controls/InputEmail';
import { normalizeFiles } from '@/admin/utils/helper';
import { useCreateNotification } from '@/admin/hooks/useCreateNotification';
import DropzoneThumbnail from '@/admin/components/form/dropzone/DropzoneThumbnail';

const ProfilePersonalFormMainColumn = ({ setValue, setUser, register, fieldErrors, user }) => {
    const { addNotification } = useCreateNotification();
    const [userAvatar, setUserAvatar] = useState(normalizeFiles(user?.avatar));

    const setDropzoneValue = (avatar) => {
        setValue('avatar', avatar);
        setUserAvatar(avatar);
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
