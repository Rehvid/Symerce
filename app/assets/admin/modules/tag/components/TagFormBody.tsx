import { hasAnyFieldError } from '@admin/common/utils/formUtils';
import FormSection from '@admin/common/components/form/FormSection';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import InputField from '@admin/common/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/common/utils/validationRules';
import React  from 'react';
import Chrome from '@uiw/react-color-chrome';
import { Controller } from 'react-hook-form';
import Switch from '@admin/common/components/form/input/Switch';

const TagFormBody = ({register, fieldErrors, control}) => {
   return (
     <FormSection title="Informacje" forceOpen={hasAnyFieldError(fieldErrors, ['name'])}>
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
         label={<InputLabel label="Kolor tła" htmlFor="backgroundColor"  />}
       >
         <Controller
           name="backgroundColor"
           control={control}
           render={({ field }) => (
             <Chrome
               color={field.value}
               onChange={(color) => field.onChange(color.hexa)}
             />
           )}
         />
       </FormGroup>

       <FormGroup
         label={<InputLabel label="Kolor textu" htmlFor="textColor"  />}
       >
         <Controller
           name="textColor"
           control={control}
           render={({ field }) => (
             <Chrome
               color={field.value}
               onChange={(color) => field.onChange(color.hexa)}
             />
           )}
         />
       </FormGroup>
       <FormGroup label={ <InputLabel label="Aktywny?" /> }>
         <Switch {...register('isActive')} />
       </FormGroup>
     </FormSection>
   )
}

export default TagFormBody;
