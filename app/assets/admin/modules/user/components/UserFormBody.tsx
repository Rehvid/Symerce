import React, { FC } from 'react';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import { DropzoneVariant } from '@admin/common/components/dropzone/Dropzone';
import FormSection from '@admin/common/components/form/FormSection';
import { Control, FieldErrors, UseFormRegister, UseFormSetValue } from 'react-hook-form';
import { UserFormData } from '@admin/modules/user/interfaces/UserFormData';
import SingleImageUploader from '@admin/common/components/form/SingleImageUploader';
import { UserFormContext } from '@admin/modules/user/interfaces/UserFormContext';
import ControlledReactSelect from '@admin/common/components/form/reactSelect/ControlledReactSelect';
import PasswordFields from '@admin/common/components/form/fields/PasswordFields';
import Firstname from '@admin/common/components/form/fields/Firstname';
import Surname from '@admin/common/components/form/fields/Surname';
import Email from '@admin/common/components/form/fields/Email';
import FormSwitchField from '@admin/common/components/form/fields/formGroup/FormSwitchField';

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
                <Firstname register={register} fieldErrors={fieldErrors} />
            </FormGroup>

            <FormGroup label={<InputLabel isRequired={true} label="Nazwisko" htmlFor="surname" />}>
                <Surname register={register} fieldErrors={fieldErrors} />
            </FormGroup>

            <FormGroup label={<InputLabel isRequired={true} label="Email" htmlFor="email" />}>
                <Email register={register} fieldErrors={fieldErrors} isRequired={true} />
            </FormGroup>

            <FormGroup label={<InputLabel isRequired={true} label="Role" />}>
                <ControlledReactSelect
                    isMulti={true}
                    name="roles"
                    control={control}
                    options={formContext?.availableRoles}
                />
            </FormGroup>

            <PasswordFields register={register} fieldErrors={fieldErrors} isEditMode={isEditMode} />

            <FormSwitchField register={register} fieldErrors={fieldErrors} name="isActive" label="Aktywny?" />
        </FormSection>
    );
};

export default UserFormBody;
