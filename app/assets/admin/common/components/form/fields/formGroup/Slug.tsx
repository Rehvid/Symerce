import InputLabel from '@admin/common/components/form/input/InputLabel';
import Description from '@admin/common/components/Description';
import InputField from '@admin/common/components/form/input/InputField';
import FormGroup from '@admin/common/components/form/FormGroup';
import React from 'react';
import { FieldErrors, Path, UseFormRegister } from 'react-hook-form';
import { createConditionalValidator } from '@admin/common/utils/formUtils';
import { validationRules } from '@admin/common/utils/validationRules';


export interface SlugInterface {
    slug?: string | null;
}

interface SlugProps <T extends SlugInterface> {
    register: UseFormRegister<T>;
    fieldErrors: FieldErrors<T>;
    isRequired: boolean;
}

const Slug = <T extends SlugInterface>({
   register,
   fieldErrors,
   isRequired = false,
}: SlugProps<T>) => (
    <FormGroup
        label={<InputLabel isRequired={isRequired} label="Przyjazny URL" htmlFor="slug" />}
        description={<Description>Automatycznie generowany z nazwy, jeżeli nic nie zostanie podane.</Description>}
    >
        <InputField
            type="text"
            id="slug"
            hasError={!!fieldErrors?.slug}
            errorMessage={fieldErrors?.slug?.message as string | undefined}
            {...register('slug' as Path<T>, {
                validate: createConditionalValidator(
                    validationRules.minLength(3),
                    validationRules.slug()
                ),
            })}
        />
    </FormGroup>
);

export default Slug;
