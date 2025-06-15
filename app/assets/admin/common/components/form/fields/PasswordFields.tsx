import React from 'react';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import InputPassword from '@admin/common/components/form/input/InputPassword';
import { validationRules } from '@admin/common/utils/validationRules';
import { FieldErrors, Path, UseFormRegister } from 'react-hook-form';

export interface Password {
    password?: string | null;
    passwordConfirmation?: string | null;
}


interface PasswordSectionProps<T extends Password> {
    register: UseFormRegister<T>;
    fieldErrors: FieldErrors<T>;
    isEditMode: boolean;
}

const PasswordFields = <T extends Password>({
 register,
 fieldErrors,
 isEditMode,
}: PasswordSectionProps<T>) => (
    <>
        <FormGroup label={<InputLabel isRequired={!isEditMode} label="Hasło" htmlFor="password" />}>
            {isEditMode ? (
                <InputPassword
                    id="password"
                    hasError={!!fieldErrors?.password}
                    errorMessage={fieldErrors?.password?.message as string | undefined}
                    {...register('password' as Path<T>, {
                        ...validationRules.password(),
                    })}
                />
            ) : (
                <InputPassword
                    id="password"
                    hasError={!!fieldErrors?.password}
                    errorMessage={fieldErrors?.password?.message as string | undefined}
                    {...register('password' as Path<T>, {
                        ...validationRules.required(),
                        ...validationRules.password(),
                    })}
                />
            )}
        </FormGroup>
        <FormGroup label={<InputLabel isRequired={!isEditMode} label="Powtórz hasło" htmlFor="passwordConfirmation" />}>
            {isEditMode ? (
                <InputPassword
                    id="password-confirmation"
                    hasError={!!fieldErrors?.passwordConfirmation}
                    errorMessage={fieldErrors?.passwordConfirmation?.message as string | undefined}
                    {...register('passwordConfirmation' as Path<T>, {
                        validate(passwordConfirmation, { password }) {
                            return passwordConfirmation === password || 'Hasła muszą być identyczne.';
                        },
                    })}
                />
            ) : (
                <InputPassword
                    id="password-confirmation"
                    hasError={!!fieldErrors?.passwordConfirmation}
                    errorMessage={fieldErrors?.passwordConfirmation?.message as string | undefined}
                    {...register('passwordConfirmation' as Path<T>, {
                        ...validationRules.required(),
                        validate(passwordConfirmation, { password }) {
                            return passwordConfirmation === password || 'Hasła muszą być identyczne.';
                        },
                    })}
                />
            )}
        </FormGroup>
    </>
)

export default PasswordFields;
