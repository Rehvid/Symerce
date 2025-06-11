import { hasAnyFieldError } from '@admin/common/utils/formUtils';
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
    setValue
}) => {

 return (
   <FormSection title="Informacje" forceOpen={hasAnyFieldError(fieldErrors, ['name'])}>
       <SingleImageUploader
           label="Miniaturka"
           fieldName="thumbnail"
           setValue={setValue}
           initialValue={formData?.thumbnail}
       />

     <FormGroup
       label={<InputLabel isRequired={true} label="Nazwa" htmlFor="name"  />}
     >
       <InputField
         type="text"
         id="name"
         hasError={!!fieldErrors?.name}
         errorMessage={fieldErrors?.name?.message}
         icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
         {...register('name', {
           ...validationRules.required(),
           ...validationRules.minLength(2),
         })}
       />
     </FormGroup>

     <FormGroup
       label={<InputLabel label="Slug" htmlFor="slug"  />}
     >
       <InputField
         type="text"
         id="slug"
         hasError={!!fieldErrors?.slug}
         errorMessage={fieldErrors?.slug?.message}
         icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
         {...register('slug')}
       />
     </FormGroup>

     <FormGroup
       label={<InputLabel label="Meta tytuł" htmlFor="metaTitle"  />}
     >
       <InputField
         type="text"
         id="metaTitle"
         hasError={!!fieldErrors?.metaTitle}
         errorMessage={fieldErrors?.metaTitle?.message}
         icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
         {...register('metaTitle')}
       />
     </FormGroup>

     <FormGroup
       label={<InputLabel label="Meta opis" htmlFor="metaDescription"  />}
     >
       <textarea {...register('metaDescription')} className="w-full rounded-lg border border-gray-300 p-2 transition-all focus:ring-4 focus:border-primary focus:border-1 focus:outline-hidden focus:ring-primary-light" />
     </FormGroup>

     <FormGroup
       label={<InputLabel label="Opis" htmlFor="description" />}
     >
       <Controller
         name="description"
         control={control}
         defaultValue=""
         render={({ field }) => <RichTextEditor value={field.value ?? ''} onChange={field.onChange} />}
       />
     </FormGroup>

     <FormGroup
       label={<InputLabel isRequired={true} label="Kategoria nadrzędna"   />}
     >
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


     <FormGroup label={ <InputLabel label="Aktywny?" /> }>
       <Switch {...register('isActive')} />
     </FormGroup>

   </FormSection>
 );
}

export default CategoryFormBody;
