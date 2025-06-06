import Switch from '@admin/common/components/form/input/Switch';

const SettingInputTypeCheckbox = ({register}) => {
  return (
    <Switch {...register('value')} />
  )
}

export default SettingInputTypeCheckbox;
