import FormSection from '@admin/common/components/form/FormSection';
import { hasAnyFieldError } from '@admin/common/utils/formUtils';
import InputField from '@admin/common/components/form/input/InputField';
import { validationRules } from '@admin/common/utils/validationRules';
import { DynamicFields } from '@admin/common/components/form/DynamicFields';
import React, { FC } from 'react';
import { Control, FieldErrors, Path, UseFormRegister } from 'react-hook-form';
import { PaymentMethodFormData } from '@admin/modules/paymentMethod/interfaces/PaymentMethodFormData';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import FormGroup from '@admin/common/components/form/FormGroup';

interface PaymentMethodConfigurationSectionProps {
    register: UseFormRegister<PaymentMethodFormData>;
    fieldErrors: FieldErrors<PaymentMethodFormData>;
    control: Control<PaymentMethodFormData>;
}

const PaymentMethodConfigurationSection: FC<PaymentMethodConfigurationSectionProps> = ({register, fieldErrors, control}) => (
  <FormSection title="Dodatkowa konfiguracja" forceOpen={hasAnyFieldError(fieldErrors, ['name'])}>
      <DynamicFields
        name="config"
        control={control}
        renderItem={(index, namePrefix) => (
          <div className="space-y-2 flex flex-col gap-4">
              <FormGroup label={<InputLabel isRequired={true} label="Nazwa"   />}>
                    <InputField
                      {...register(`${namePrefix}.key` as Path<PaymentMethodFormData>, {
                        ...validationRules.required(),
                      })}
                      placeholder="Klucz konfiguracji"
                      type="text"
                      hasError={!!fieldErrors?.config?.[index]?.key}
                      errorMessage={fieldErrors?.config?.[index]?.key?.message}
                    />
              </FormGroup>
              <FormGroup label={<InputLabel isRequired={true} label="Wartość"   />}>
                    <InputField
                      {...register(`${namePrefix}.value` as Path<PaymentMethodFormData>, {
                        ...validationRules.required(),
                      })}
                      placeholder="Wartość konfiguracji"
                      type="text"
                      hasError={!!fieldErrors?.config?.[index]?.value}
                      errorMessage={fieldErrors?.config?.[index]?.value?.message}
                    />
              </FormGroup>
          </div>
        )}
      />
  </FormSection>
)

export default PaymentMethodConfigurationSection;
