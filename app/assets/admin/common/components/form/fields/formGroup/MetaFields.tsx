import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import InputField from '@admin/common/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import React from 'react';
import { FieldErrors, FieldValues, Path, UseFormRegister } from 'react-hook-form';
import { createConditionalValidator } from '@admin/common/utils/formUtils';
import { validationRules } from '@admin/common/utils/validationRules';
import TextareaField from '@admin/common/components/form/input/TextareaField';

export interface MetaFieldsInterface {
    metaTitle?: string | null;
    metaDescription?: string | null;
}

interface MetaFieldsProps <T extends FieldValues> {
    register: UseFormRegister<T>;
    fieldErrors: FieldErrors<T>;
}

const MetaFields = <T extends FieldValues>({
    register,
    fieldErrors,
}: MetaFieldsProps<T>) => (
    <>
        <FormGroup label={<InputLabel label="Meta tytuł" htmlFor="metaTitle" />}>
            <InputField
                type="text"
                id="metaTitle"
                hasError={!!fieldErrors?.metaTitle}
                errorMessage={fieldErrors?.metaTitle?.message as string | undefined}
                icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
                {...register('metaTitle' as Path<T>, {
                    validate: createConditionalValidator(
                        validationRules.minLength(3)
                    ),
                })}
            />
        </FormGroup>

        <FormGroup label={<InputLabel label="Meta opis" htmlFor="metaDescription" />}>
            <TextareaField
                id="metaDescription"
                hasError={!!fieldErrors?.metaDescription}
                errorMessage={fieldErrors?.metaDescription?.message as string | undefined}
                {...register('metaDescription' as Path<T>, {
                    validate: createConditionalValidator(
                        validationRules.minLength(12)
                    ),
                })}
            />
        </FormGroup>
    </>
);


export default MetaFields;
