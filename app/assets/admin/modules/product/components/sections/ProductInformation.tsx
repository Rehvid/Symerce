import React from 'react';
import FormSection from '@admin/shared/components/form/FormSection';
import InputLabel from '@admin/shared/components/form/input/InputLabel';
import FormGroup from '@admin/shared/components/form/FormGroup';
import Description from '@admin/shared/components/Description';
import Switch from '@admin/shared/components/form/input/Switch';
import { validationRules } from '@admin/utils/validationRules';
import LabelNameIcon from '@/images/icons/label-name.svg';
import InputField from '@admin/shared/components/form/input/InputField';
import { Control, FieldErrors, UseFormRegister, Controller } from 'react-hook-form';
import RichTextEditor from '@admin/shared/components/form/input/RichTextEditor';
import { hasAnyFieldError } from '@admin/shared/utils/formUtils';
import { ProductFormDataInterface } from '@admin/modules/product/interfaces/ProductFormDataInterface';
import Select from '@admin/shared/components/form/select/Select';
import ReactSelect from '@admin/shared/components/form/reactSelect/ReactSelect';

interface ProductInformationProps {
    register: UseFormRegister<ProductFormDataInterface>,
    fieldErrors: FieldErrors<ProductFormDataInterface>;
    control: Control<ProductFormDataInterface>;
}

const ProductInformation: React.FC<ProductInformationProps> = ({register, fieldErrors, control, formContext}) => {
    return (
      <FormSection title="Podstawowe informacje" forceOpen={hasAnyFieldError(fieldErrors, ['name'])}>

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
                  ...validationRules.minLength(3),
              })}
            />
        </FormGroup>

        <FormGroup
          label={<InputLabel label="Opis" />}
        >
          <Controller
              name="description"
              control={control}
              defaultValue=""
              render={({ field }) => <RichTextEditor value={field.value ?? ''} onChange={field.onChange} />}
          />
        </FormGroup>

          <FormGroup
            label={<InputLabel isRequired={true} label="Producent"  />}
          >
              <Controller
                name="brand"
                control={control}
                defaultValue={null}
                render={({ field, fieldState }) => (
                    <ReactSelect
                      options={formContext?.availableBrands || []}
                      value={field.value}
                      onChange={(option) => {
                        field.onChange(option);
                      }}
                      hasError={fieldState.invalid}
                      errorMessage={fieldState.error?.message}
                    />
                )}
              />
          </FormGroup>


          <FormGroup label={ <InputLabel label="Produkt widoczny na sklepie?" /> }>
          <Switch {...register('isActive')} />
        </FormGroup>

      </FormSection>
    )
}

export default ProductInformation;
