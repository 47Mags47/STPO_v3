import dayjs from "dayjs";

export const formatDate = (date, format = "YYYY-MM-DD") => {
  return dayjs(date).format(format);
};

export const isSameDay = (d1, d2) => {
  return dayjs(d1).isSame(dayjs(d2), "day");
};

export const getMonthDays = (date) => {
  const startOfMonth = dayjs(date).startOf("month");
  const endOfMonth = dayjs(date).endOf("month");

  const days = [];
  for (let i = 0; i < startOfMonth.day(); i++) {
    days.push(null);
  }

  for (let d = 1; d <= endOfMonth.date(); d++) {
    days.push(startOfMonth.date(d).toDate());
  }

  return days;
};
