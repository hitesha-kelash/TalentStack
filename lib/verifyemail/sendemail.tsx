import { Resend } from "resend";
import { VerificationEmailTemplate } from "./email-template";

const resend = new Resend(process.env.RESEND_API);

interface SendVerificationEmailProps {
  firstName: string;
  email: string;
  verifyTokengen: string;
}

export async function sendVerificationEmail({
  firstName,
  email,
  verifyTokengen,
}: SendVerificationEmailProps) {
  const template = await VerificationEmailTemplate({
    firstName,
    email,
    verificationToken: verifyTokengen,
  });
  try {
    const { data, error } = await resend.emails.send({
      from: "FreeFlow <onboarding@ankitmishra.xyz>",
      to: [email],
      subject: "Verify Your Email Account",
      react: template,
    });

    if (error) {
      return Response.json({ error }, { status: 500 });
    }

    return Response.json(data);
  } catch (error) {
    return Response.json({ error }, { status: 500 });
  }
}
