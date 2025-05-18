import Input from '@/admin/components/form/controls/Input';
import { validationRules } from '@/admin/utils/validationRules';
import UserIcon from '@/images/icons/user.svg';
import InputEmail from '@/admin/components/form/controls/InputEmail';
import MultiSelect from '@/admin/components/form/controls/MultiSelect';
import { Controller } from 'react-hook-form';
import InputPassword from '@/admin/components/form/controls/InputPassword';
import Heading from '@/admin/components/common/Heading';
import Dropzone from '@/admin/components/form/dropzone/Dropzone';
import DropzoneThumbnail from '@/admin/components/form/dropzone/DropzoneThumbnail';
import Switch from '@/admin/components/form/controls/Switch';
import { normalizeFiles } from '@/admin/utils/helper';
import { useDropzoneLogic } from '@/admin/hooks/useDropzoneLogic';

const UserFormMainColumn = ({ register, fieldErrors, control, params, setValue, formData, setFormData }) => {
    const userAvatar = normalizeFiles(formData?.avatar);
    const setDropzoneValue = (avatar) => {
        setValue('avatar', avatar);
        setFormData((prevFormData) => ({
            ...prevFormData,
            avatar,
        }));
    };

    const { onDrop, errors, removeFile } = useDropzoneLogic(setDropzoneValue, formData);

    return (
        <>
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

            <Controller
                name="roles"
                control={control}
                defaultValue={[]}
                rules={{
                    ...validationRules.required(),
                }}
                render={({ field }) => (
                    <div>
                        <MultiSelect
                            label="Role"
                            options={formData?.availableRoles || []}
                            selected={field.value}
                            onChange={(value, checked) => {
                                const newValue = checked
                                    ? [...field.value, value]
                                    : field.value.filter((v) => v !== value);
                                field.onChange(newValue);
                            }}
                            isRequired
                            hasError={!!fieldErrors?.roles}
                            errorMessage={fieldErrors?.roles?.message}
                        />
                    </div>
                )}
            />

            <InputPassword
                id="password"
                label="Hasło"
                isRequired={params.id === null}
                hasError={!!fieldErrors?.password}
                errorMessage={fieldErrors?.password?.message}
                {...register('password', {
                    ...validationRules.password(),
                })}
            />
            <InputPassword
                id="password-confirmation"
                label="Powtórz hasło"
                isRequired={params.id === null}
                hasError={!!fieldErrors?.passwordConfirmation}
                errorMessage={fieldErrors?.passwordConfirmation?.message}
                {...register('passwordConfirmation', {
                    validate(passwordConfirmation, { password }) {
                        return passwordConfirmation === password || 'Hasła muszą być identyczne.';
                    },
                })}
            />

            <Heading level="h4">
                <span className="flex items-center">Miniaturka</span>
            </Heading>
            <Dropzone onDrop={onDrop} errors={errors} containerClasses="relative max-w-lg" variant="mainColumn">
                {userAvatar.length > 0 &&
                    userAvatar.map((file, key) => (
                        <DropzoneThumbnail file={file} removeFile={removeFile} variant="single" key={key} index={key} />
                    ))}
            </Dropzone>

            <Switch label="Aktywny?" {...register('isActive')} />
        </>
    );
};

export default UserFormMainColumn;
