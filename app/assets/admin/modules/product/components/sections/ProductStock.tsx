import React from 'react';
import FormSection from '@admin/shared/components/form/FormSection';
import FormGroup from '@admin/shared/components/form/FormGroup';
import InputLabel from '@admin/shared/components/form/input/InputLabel';
import Switch from '@admin/shared/components/form/input/Switch';
import InputField from '@admin/shared/components/form/input/InputField';
import NumberIcon from '@/images/icons/number.svg';
import { validationRules } from '@admin/utils/validationRules';
import Description from '@admin/shared/components/Description';
import { FieldErrors, UseFormRegister } from 'react-hook-form';
import { ProductFormData } from '@admin/modules/product/components/ProductFormBody';

interface ProductStockProps {
  fieldErrors: FieldErrors<ProductFormData>;
  register: UseFormRegister<ProductFormData>;
}

const ProductStock: React.FC<ProductStockProps> = ({fieldErrors, register}) => {
  return (
    <FormSection title="Magazyn">

      <FormGroup
        label={ <InputLabel isRequired={true} label="Dostępna ilość" />}
      >
        <InputField
          type="number"
          id="stockAvailableQuantity"
          hasError={!!fieldErrors?.stockAvailableQuantity}
          errorMessage={fieldErrors?.stockAvailableQuantity?.message}
          icon={<NumberIcon className="text-gray-500 w-[16px] h-[16px]" />}
          {...register('stockAvailableQuantity', {
            ...validationRules.required(),
            ...validationRules.min(0),
          })}
        />
      </FormGroup>

      <FormGroup
        label={ <InputLabel  label="Próg alarmowy (opcjonalny)" />}
        description={<Description> Pozostaw puste, aby wyłączyć alert poniżej progu, nawet gdy opcja jest zaznaczona</Description>}
      >
        <InputField
          type="number"
          id="stockLowStockThreshold"
          hasError={!!fieldErrors?.stockLowStockThreshold}
          errorMessage={fieldErrors?.stockLowStockThreshold?.message}
          icon={<NumberIcon className="text-gray-500 w-[16px] h-[16px]" />}
          {...register('stockLowStockThreshold')}
        />
      </FormGroup>

      <FormGroup
        label={ <InputLabel label="Limit magazynu (opcjonalny)" />}
        description={<Description>Pozostaw puste, aby nie wyświetlać alertu, nawet gdy opcja jest zaznaczona.</Description>}
      >
        <InputField
          type="number"
          id="stockMaximumStockLevel"
          hasError={!!fieldErrors?.stockMaximumStockLevel}
          errorMessage={fieldErrors?.stockMaximumStockLevel?.message}
          icon={<NumberIcon className="text-gray-500 w-[16px] h-[16px]" />}
          {...register('stockMaximumStockLevel')}
        />
      </FormGroup>

      <FormGroup
        label={ <InputLabel label="EAN13" />}
      >
        <InputField
          type="number"
          id="stockEan13"
          hasError={!!fieldErrors?.stockEan13}
          errorMessage={fieldErrors?.stockEan13?.message}
          icon={<NumberIcon className="text-gray-500 w-[16px] h-[16px]" />}
          {...register('stockEan13')}
        />
      </FormGroup>

      <FormGroup
        label={ <InputLabel  label="SKU" />}
      >
        <InputField
          type="number"
          id="stockSku"
          hasError={!!fieldErrors?.stockSku}
          errorMessage={fieldErrors?.stockSku?.message}
          icon={<NumberIcon className="text-gray-500 w-[16px] h-[16px]" />}
          {...register('stockSku')}
        />
      </FormGroup>

      <FormGroup label={ <InputLabel label="Powiadom o niskim stanie" /> }>
        <Switch {...register('stockNotifyOnLowStock')} />
      </FormGroup>

      <FormGroup label={ <InputLabel label="Wyświetl na sklepie informację o niskim stanie" /> }>
        <Switch {...register('stockVisibleInStore')} />
      </FormGroup>
    </FormSection>
  )
}

export default ProductStock;
