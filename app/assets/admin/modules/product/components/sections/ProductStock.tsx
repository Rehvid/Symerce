import React from 'react';
import FormSection from '@admin/common/components/form/FormSection';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import Switch from '@admin/common/components/form/input/Switch';
import InputField from '@admin/common/components/form/input/InputField';
import NumberIcon from '@/images/icons/number.svg';
import { validationRules } from '@admin/common/utils/validationRules';
import Description from '@admin/common/components/Description';
import { Controller, FieldErrors, UseFormRegister } from 'react-hook-form';
import { ProductFormDataInterface } from '@admin/modules/product/interfaces/ProductFormDataInterface';
import { DynamicFields } from '@admin/common/components/form/DynamicFields';
import DatePicker from 'react-datepicker';
import Error from '@admin/common/components/Error';
import ReactSelect from '@admin/common/components/form/reactSelect/ReactSelect';

interface ProductStockProps {
  fieldErrors: FieldErrors<ProductFormDataInterface>;
  register: UseFormRegister<ProductFormDataInterface>;
}

const ProductStock: React.FC<ProductStockProps> = ({fieldErrors, register, control, formContext}) => {
  return (
    <FormSection title="Magazyn">

      <DynamicFields
        name={'stocks'}
        control={control}
        register={register}
        renderItem={(index, innerPrefix) => (
          <div className="space-y-2 flex flex-col gap-4">
            <FormGroup
              label={ <InputLabel isRequired={true} label="Dostępna ilość" />}
            >
              <InputField
                type="number"
                id="stockAvailableQuantity"
                hasError={ !!fieldErrors?.stocks?.[index]?.availableQuantity}
                errorMessage={ fieldErrors?.stocks?.[index]?.availableQuantity?.message}
                icon={<NumberIcon className="text-gray-500 w-[16px] h-[16px]" />}
                {...register(`${innerPrefix}.availableQuantity`, {
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
                icon={<NumberIcon className="text-gray-500 w-[16px] h-[16px]" />}
                {...register(`${innerPrefix}.lowStockThreshold`)}
              />
            </FormGroup>

            <FormGroup
              label={ <InputLabel label="Limit magazynu (opcjonalny)" />}
              description={<Description>Pozostaw puste, aby nie wyświetlać alertu, nawet gdy opcja jest zaznaczona.</Description>}
            >
              <InputField
                type="number"
                id="stockMaximumStockLevel"
                icon={<NumberIcon className="text-gray-500 w-[16px] h-[16px]" />}
                {...register(`${innerPrefix}.maximumStockLevel`)}
              />
            </FormGroup>

            <FormGroup
              label={ <InputLabel label="EAN13" />}
            >
              <InputField
                type="text"
                id="stockEan13"
                icon={<NumberIcon className="text-gray-500 w-[16px] h-[16px]" />}
                {...register(`${innerPrefix}.ean13`)}
              />
            </FormGroup>

            <FormGroup
              label={ <InputLabel  label="SKU" />}
            >
              <InputField
                type="text"
                id="stockSku"
                icon={<NumberIcon className="text-gray-500 w-[16px] h-[16px]" />}
                {...register(`${innerPrefix}.sku`)}
              />
            </FormGroup>

            <Controller
              name={`${innerPrefix}.restockDate`}
              control={control}
              render={({ field }) => (
                  <FormGroup
                    label={ <InputLabel label="Data następnej dostawy" />}
                    description={
                      <Description>
                        Informacja wyświetlana klientowi jako przewidywany termin dostępności produktu.
                      </Description>
                  }
                  >
                    <div className="w-full">
                      <DatePicker
                        placeholderText="Wybierz datę"
                        selected={field.value}
                        onChange={(date) => field.onChange(date)}
                        className={`
                            w-full h-[46px] rounded-lg border border-gray-300 py-2.5 pl-[16px] pr-[60px] text-sm text-gray-800 transition-all 
                            focus:border-primary focus:border-1 focus:outline-hidden  focus:ring-primary-light
                        }
                        `}
                      />
                    </div>
                  </FormGroup>
              )}
            />

            <Controller
              name={`${innerPrefix}.warehouseId`}
              control={control}
              defaultValue={[]}
              rules={{
                ...validationRules.required()
              }}
              render={({ field, fieldState }) => {
                return (
                  <FormGroup
                    label={ <InputLabel label="Magazyn" isRequired={true} />}
                  >
                    <ReactSelect
                      options={formContext.availableWarehouses || []}
                      value={field.value}
                      onChange={(option) => {
                        field.onChange(option);
                      }}
                      hasError={fieldState.invalid}
                      errorMessage={fieldState.error?.message}
                    />
                  </FormGroup>
                )

              }}
            />

          </div>
        )}
      />
    </FormSection>
  )
}

export default ProductStock;
