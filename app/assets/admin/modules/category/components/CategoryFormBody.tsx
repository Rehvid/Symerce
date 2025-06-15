import InputLabel from '@admin/common/components/form/input/InputLabel';
import FormGroup from '@admin/common/components/form/FormGroup';
import React, { FC } from 'react';
import InputField from '@admin/common/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/common/utils/validationRules';
import Switch from '@admin/common/components/form/input/Switch';
import { Control, Controller, FieldErrors, UseFormRegister, UseFormSetValue, UseFormWatch } from 'react-hook-form';
import RichTextEditor from '@admin/common/components/form/input/RichTextEditor';
import FormCategoryTree from '@admin/modules/category/components/categoryTree/FormCategoryTree';
import FormSection from '@admin/common/components/form/FormSection';
import SingleImageUploader from '@admin/common/components/form/SingleImageUploader';
import { CategoryFormData } from '@admin/modules/category/interfaces/CategoryFormData';
import { CategoryFormContext } from '@admin/modules/category/interfaces/CategoryFormContext';
import MetaFields from '@admin/common/components/form/fields/formGroup/MetaFields';
import Slug from '@admin/common/components/form/fields/formGroup/Slug';
import GenericTextField from '@admin/common/components/form/fields/formGroup/GenericTextField';
import FormSwitchField from '@admin/common/components/form/fields/formGroup/FormSwitchField';

interface CategoryFormBodyProps {
    register: UseFormRegister<CategoryFormData>;
    fieldErrors: FieldErrors<CategoryFormData>;
    control: Control<CategoryFormData>;
    formData: CategoryFormData;
    formContext: CategoryFormContext;
    entityId: number | null;
    watch: UseFormWatch<CategoryFormData>;
    setValue: UseFormSetValue<CategoryFormData>;
}

const CategoryFormBody: FC<CategoryFormBodyProps> = ({
    register,
    fieldErrors,
    control,
    formData,
    formContext,
    entityId,
    watch,
    setValue,
}) => {
    return (
        <FormSection title="Informacje" useToggleContent={false}>
            <SingleImageUploader
                label="Miniaturka"
                fieldName="thumbnail"
                setValue={setValue}
                initialValue={formData?.thumbnail}
            />

            <GenericTextField register={register} fieldErrors={fieldErrors} fieldName="name" label="Nazwa" isRequired={true} />
            <Slug register={register} fieldErrors={fieldErrors} isRequired={false} />
            <MetaFields register={register} fieldErrors={fieldErrors} />

            <FormGroup label={<InputLabel label="Opis" htmlFor="description" />}>
                <Controller
                    name="description"
                    control={control}
                    defaultValue=""
                    render={({ field }) => <RichTextEditor value={field.value ?? ''} onChange={field.onChange} />}
                />
            </FormGroup>

            <FormGroup label={<InputLabel isRequired={true} label="Kategoria nadrzędna" />}>
                {formContext?.tree && formContext?.tree?.length > 0 && (
                    //   TODO: Resolve problem with not open tree if selected value is provided
                    <FormCategoryTree
                        hasError={!!fieldErrors?.parentCategoryId}
                        errorMessage={fieldErrors?.parentCategoryId?.message}
                        register={register('parentCategoryId')}
                        disabledCategoryId={entityId}
                        categories={formContext.tree || []}
                        selected={formData?.parentCategoryId}
                        watch={watch}
                        nameWatchedValue="parentCategoryId"
                    />
                )}
            </FormGroup>

            <FormSwitchField register={register} name={"isActive"} label={"Aktywna"} />
        </FormSection>
    );
};

export default CategoryFormBody;
