import React, { useState } from 'react';
import { normalizeFiles } from '@admin/utils/helper';
import { UploadFileInterface } from '@admin/shared/interfaces/UploadFileInterface';
import { useDropzoneLogic } from '@admin/hooks/useDropzoneLogic';
import { hasAnyFieldError } from '@admin/shared/utils/formUtils';
import FormGroup from '@admin/shared/components/form/FormGroup';
import InputLabel from '@admin/shared/components/form/input/InputLabel';
import Dropzone from '@admin/components/form/dropzone/Dropzone';
import DropzoneThumbnail from '@admin/components/form/dropzone/DropzoneThumbnail';
import FormSection from '@admin/shared/components/form/FormSection';
import InputField from '@admin/shared/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/utils/validationRules';
import { Controller } from 'react-hook-form';
import ReactSelect from '@admin/shared/components/form/reactSelect/ReactSelect';
import Switch from '@admin/shared/components/form/input/Switch';
import InputPassword from '@admin/shared/components/form/input/InputPassword';

const UserFormBody = ({formData, setValue, register, control, isEditMode, formContext, fieldErrors}) => {
  const [avatar, setAvatar] = useState<any>(normalizeFiles(formData?.avatar));
  const [isDefaultOptionSelected, setIsDefaultOptionSelected] = useState<boolean>(false);


  let selectedRoles = [];
  if (formData.roles) {
    selectedRoles = formContext.availableRoles.filter(role =>
      formData.roles.includes(role.value)
    );
  }

  console.log(isDefaultOptionSelected);
  console.log(selectedRoles);

  const setDropzoneValue = (image: UploadFileInterface) => {
    setValue('avatar', image);
    setAvatar(image);
  };

  const { onDrop, errors, removeFile } = useDropzoneLogic(setDropzoneValue, avatar);

  return (
    <FormSection title="Informacje" forceOpen={hasAnyFieldError(fieldErrors, ['name'])}>

      <FormGroup  label={<InputLabel label="Avatar"  />} >
        <Dropzone onDrop={onDrop} errors={errors} containerClasses="relative max-w-lg" variant="mainColumn">
          {avatar.length > 0 &&
            avatar.map((file, key) => (
              <DropzoneThumbnail file={file} removeFile={removeFile} variant="single" key={key} index={key} />
            ))}
        </Dropzone>
      </FormGroup>

      <FormGroup
        label={<InputLabel isRequired={true} label="Imie" htmlFor="firstname"  />}
      >
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

      <FormGroup
        label={<InputLabel isRequired={true} label="Nazwisko" htmlFor="surname"  />}
      >
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

      <FormGroup
        label={<InputLabel isRequired={true} label="Email" htmlFor="email"  />}
      >
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

      <FormGroup
        label={<InputLabel isRequired={true} label="Role"  />}
      >
        <Controller
          name="roles"
          control={control}
          defaultValue={selectedRoles}
          rules={{
            ...validationRules.required(),
          }}
          render={({ field, fieldState }) => (
            <ReactSelect
              options={formContext?.availableRoles || []}
              value={isDefaultOptionSelected ? field.value : selectedRoles}
              onChange={(option) => {
                if (!isDefaultOptionSelected) {
                  setIsDefaultOptionSelected(true);
                }
                field.onChange(option);
              }}
              hasError={fieldState.invalid}
              errorMessage={fieldState.error?.message}
              isMulti={true}
            />
          )}
        />
      </FormGroup>

      <FormGroup
        label={<InputLabel isRequired={true} label="Hasło" htmlFor="password"  />}
      >
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
      <FormGroup
        label={<InputLabel isRequired={true} label="Powtórz hasło" htmlFor="passwordConfirmation"  />}
      >
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

      <FormGroup label={ <InputLabel label="Aktywny?" /> }>
        <Switch {...register('isActive')} />
      </FormGroup>

    </FormSection>
  )
}

export default UserFormBody;
