import React from 'react';
import FormSection from '@admin/common/components/form/FormSection';
import { Control, UseFormRegister, UseFormWatch, Controller, FieldErrors } from 'react-hook-form';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import InputField from '@admin/common/components/form/input/InputField';
import { validationRules } from '@admin/common/utils/validationRules';
import FormGroup from '@admin/common/components/form/FormGroup';
import Switch from '@admin/common/components/form/input/Switch';
import Error from '@admin/common/components/Error';
import CurrencyIcon from '@/images/icons/currency.svg';
import NumberIcon from '@/images/icons/number.svg';
import DatePicker from 'react-datepicker';
import { ProductFormData } from '@admin/modules/product/interfaces/ProductFormData';
import { useAppData } from '@admin/common/context/AppDataContext';
import { ProductFormContext } from '@admin/modules/product/interfaces/ProductFormContext';
import ControlledReactSelect from '@admin/common/components/form/reactSelect/ControlledReactSelect';

interface ProductPricingProps {
  register: UseFormRegister<ProductFormData>;
  control: Control<ProductFormData>;
  watch: UseFormWatch<ProductFormData>;
  formContext?: ProductFormContext;
  fieldErrors: FieldErrors<ProductFormData>;
}

const ProductPricing: React.FC<ProductPricingProps> = ({register, fieldErrors, watch, formContext, control}) => {
  const { currency } = useAppData();

  return (
    <FormSection title="Cena">
      <FormGroup
        label={<InputLabel isRequired={true} label="Cena podstawowa" htmlFor="regularPrice"  />}
      >
        <InputField
          type="text"
          id="regularPrice"
          hasError={!!fieldErrors?.regularPrice}
          errorMessage={fieldErrors?.regularPrice?.message}
          icon={<CurrencyIcon className="text-gray-500 w-[16px] h-[16px]" />}
          {...register('regularPrice', {
            ...validationRules.required(),
            ...validationRules.numeric(currency?.roundingPrecision),
          })}
        />
      </FormGroup>

      <FormGroup label={ <InputLabel label="Dodać promocje?" /> }>
        <Switch {...register('promotionIsActive')} />
      </FormGroup>

      {watch().promotionIsActive && (
        <>
          <FormGroup
            label={ <InputLabel isRequired={true} label="Zakres promocji" />}
          >
            <Controller
              name="promotionDateRange"
              control={control}
              rules={{
              validate: (promotionDateRange: Date[] | undefined) => {
                  const [start, end] = promotionDateRange || [];
                  if (!start || !end) {
                    return "Musisz wybrać oba terminy";
                  }
                  return true;
                }
              }}
              render={({ field }) => (
                <div className="w-full">
                  <DatePicker
                    selectsRange
                    startDate={field.value?.[0] ?? null}
                    endDate={field.value?.[1] ?? null}
                    placeholderText="Wybierz datę"
                    onChange={(date) => field.onChange(date)}
                    className={`
                        w-full h-[46px] rounded-lg border border-gray-300 py-2.5 pl-[16px] pr-[60px] text-sm text-gray-800 transition-all 
                        ${!!fieldErrors?.promotionDateRange
                          ? 'border-red-500 text-red-900 focus:border-1 focus:outline-hidden focus:ring-red-100'
                          : 'focus:border-primary focus:border-1 focus:outline-hidden  focus:ring-primary-light'
                        }
                    `}
                  />
                  {!!fieldErrors?.promotionDateRange && (
                    <Error message={fieldErrors?.promotionDateRange?.message} />
                  )}
                </div>
              )}
            />
          </FormGroup>
          <FormGroup
            label={ <InputLabel isRequired={true} label="Typ promocji" />}
          >
            <ControlledReactSelect
                name="promotionReductionType"
                control={control}
                rules={{
                    ...validationRules.required(),
                }}
                options={formContext?.availablePromotionTypes || []}
            />
          </FormGroup>
          <FormGroup
            label={ <InputLabel isRequired={true} label="Obniżka" />}
          >
            <InputField
              type="number"
              id="promotionReduction"
              hasError={!!fieldErrors?.promotionReduction}
              errorMessage={fieldErrors?.promotionReduction?.message}
              icon={<NumberIcon className="text-gray-500 w-[16px] h-[16px]" />}
              {...register('promotionReduction', {
                ...validationRules.required(),
                ...validationRules.min(0),
              })}
            />
          </FormGroup>
        </>
      )}

    </FormSection>
  )
}

export default ProductPricing;
