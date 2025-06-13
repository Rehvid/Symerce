import React, { FC } from 'react';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import { DropzoneVariant } from '@admin/common/components/dropzone/Dropzone';
import FormSection from '@admin/common/components/form/FormSection';
import InputField from '@admin/common/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/common/utils/validationRules';
import { Control, FieldErrors, UseFormRegister, UseFormSetValue } from 'react-hook-form';
import Switch from '@admin/common/components/form/input/Switch';
import InputPassword from '@admin/common/components/form/input/InputPassword';
import { UserFormData } from '@admin/modules/user/interfaces/UserFormData';
import SingleImageUploader from '@admin/common/components/form/SingleImageUploader';
import { UserFormContext } from '@admin/modules/user/interfaces/UserFormContext';
import ControlledReactSelect from '@admin/common/components/form/reactSelect/ControlledReactSelect';

interface UserFormBodyProps {
    formData: UserFormData;
    register: UseFormRegister<UserFormData>;
    control: Control<UserFormData>;
    fieldErrors: FieldErrors<UserFormData>;
    setValue: UseFormSetValue<UserFormData>;
    formContext: UserFormContext;
    isEditMode: boolean;
}

const UserFormBody: FC<UserFormBodyProps> = ({
    formData,
    setValue,
    register,
    control,
    isEditMode,
    formContext,
    fieldErrors,
}) => {
    return (
        <FormSection title="Informacje" useToggleContent={false}>
            <SingleImageUploader
                label="Avatar"
                fieldName="avatar"
                initialValue={formData?.avatar}
                setValue={setValue}
                variant={DropzoneVariant.Avatar}
            />

            <FormGroup label={<InputLabel isRequired={true} label="Imie" htmlFor="firstname" />}>
                <InputField
                    type="text"
                    id="name"
                    hasError={!!fieldErrors?.firstname}
                    errorMessage={fieldErrors?.firstname?.message}
                    icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
                    {...register('firstname', {
                        ...validationRules.required(),
                        ...validationRules.minLength(2),
                    })}
                />
            </FormGroup>

            <FormGroup label={<InputLabel isRequired={true} label="Nazwisko" htmlFor="surname" />}>
                <InputField
                    type="text"
                    id="name"
                    hasError={!!fieldErrors?.surname}
                    errorMessage={fieldErrors?.surname?.message}
                    icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
                    {...register('surname', {
                        ...validationRules.required(),
                        ...validationRules.minLength(2),
                    })}
                />
            </FormGroup>

            <FormGroup label={<InputLabel isRequired={true} label="Email" htmlFor="email" />}>
                <InputField
                    type="text"
                    id="email"
                    hasError={!!fieldErrors?.email}
                    errorMessage={fieldErrors?.email?.message}
                    icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
                    {...register('email', {
                        ...validationRules.required(),
                        ...validationRules.minLength(2),
                    })}
                />
            </FormGroup>

            <FormGroup label={<InputLabel isRequired={true} label="Role" />}>
                <ControlledReactSelect
                    isMulti={true}
                    name="roles"
                    control={control}
                    options={formContext?.availableRoles}
                />
            </FormGroup>

            <FormGroup label={<InputLabel isRequired={true} label="Hasło" htmlFor="password" />}>
                <InputPassword
                    id="password"
                    isRequired={!isEditMode}
                    hasError={!!fieldErrors?.password}
                    errorMessage={fieldErrors?.password?.message}
                    {...register('password', {
                        ...validationRules.password(),
                    })}
                />
            </FormGroup>
            <FormGroup label={<InputLabel isRequired={true} label="Powtórz hasło" htmlFor="passwordConfirmation" />}>
                <InputPassword
                    id="password-confirmation"
                    isRequired={!isEditMode}
                    hasError={!!fieldErrors?.passwordConfirmation}
                    errorMessage={fieldErrors?.passwordConfirmation?.message}
                    {...register('passwordConfirmation', {
                        validate(passwordConfirmation, { password }) {
                            return passwordConfirmation === password || 'Hasła muszą być identyczne.';
                        },
                    })}
                />
            </FormGroup>

            <FormGroup label={<InputLabel label="Aktywny?" />}>
                <Switch {...register('isActive')} />
            </FormGroup>
        </FormSection>
    );
};

export default UserFormBody;
