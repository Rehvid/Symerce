const ParamTab = ({content}) => {
  const items = JSON.parse(content);
  return (
    <div className="flex flex-col gap-[2rem]">
    {items.map(({ attribute, value}, index) => (
      <div className="flex justify-between border-b border-gray-200 pb-5" key={index}>
        <span className="font-medium">{attribute}</span>
        <span>{value}</span>
      </div>
    ))}
  </div>
  )
}

export default ParamTab;
