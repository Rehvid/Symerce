import Input from '@/admin/components/form/controls/Input';
import { validationRules } from '@/admin/utils/validationRules';
import UserIcon from '@/images/icons/user.svg';
import InputEmail from '@/admin/components/form/controls/InputEmail';
import React from 'react';
import MultiSelect from '@/admin/components/form/controls/MultiSelect';
import { Controller } from 'react-hook-form';
import InputPassword from '@/admin/components/form/controls/InputPassword';

const UserFormMainColumn = ({ register, fieldErrors, control, params }) => {
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
                hasError={fieldErrors.hasOwnProperty('firstname')}
                errorMessage={fieldErrors?.firstname?.message}
                isRequired
                icon={<UserIcon className="text-gray-500" />}
            />
            <Input
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
            <InputEmail
                hasError={fieldErrors.hasOwnProperty('email')}
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
                            options={[
                                { value: 'user', label: 'Użytkownik' },
                                { value: 'admin', label: 'Administrator' },
                            ]}
                            selected={field.value}
                            onChange={(value, checked) => {
                                const newValue = checked
                                    ? [...field.value, value]
                                    : field.value.filter((v) => v !== value);
                                field.onChange(newValue);
                            }}
                            isRequired
                            hasError={fieldErrors.hasOwnProperty('roles')}
                            errorMessage={fieldErrors?.roles?.message}
                        />
                    </div>
                )}
            />

            <InputPassword
                id="password"
                label="Hasło"
                isRequired={params.id === null}
                hasError={fieldErrors.hasOwnProperty('password')}
                errorMessage={fieldErrors?.password?.message}
                {...register('password', {
                    ...validationRules.password(),
                })}
            />
            <InputPassword
                id="password-confirmation"
                label="Powtórz hasło"
                isRequired={params.id === null}
                hasError={fieldErrors.hasOwnProperty('passwordConfirmation')}
                errorMessage={fieldErrors?.passwordConfirmation?.message}
                {...register('passwordConfirmation', {
                    validate: function (passwordConfirmation, { password }) {
                        return passwordConfirmation === password || 'Hasła muszą być identyczne.';
                    },
                })}
            />
        </>
    );
};

export default UserFormMainColumn;
