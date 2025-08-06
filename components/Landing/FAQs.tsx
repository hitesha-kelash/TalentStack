"use client";
import React, { useState } from "react";
import { motion } from "framer-motion";
import MaxWidthWrapper from "../Shared/maxWidthWrapper";
import { Inter } from "next/font/google";
import { cn } from "@/lib/utils";

const InterFont = Inter({ weight: "600", subsets: ["latin"] });

interface FAQ {
  question: string;
  answer: string;
}

const faqs: FAQ[] = [
  {
    question: "What is FreelancerHub, and who is it for?",
    answer:
      "FreelancerHub is an all-in-one platform for freelancers to create stunning portfolios, manage clients, track time, and send professional invoices. It’s designed for creatives like designers, developers, and writers who want to streamline their workflow.",
  },
  {
    question: "Is FreelancerHub free to use?",
    answer:
      "Yes! Our free plan includes a portfolio, up to 5 clients, and 3 invoices per month. Upgrade to our premium plan ($9/month) for unlimited clients, invoices, and advanced features.",
  },
  {
    question: "How easy is it to build a portfolio?",
    answer:
      "Incredibly easy! Our drag-and-drop portfolio builder lets you upload images, add descriptions, and customize your layout in minutes—no coding required.",
  },
  {
    question: "Can I send invoices with payment links?",
    answer:
      "Absolutely. Generate professional PDF invoices with built-in payment links via Stripe or PayPal, making it simple for clients to pay you fast.",
  },
  {
    question: "Is my data secure?",
    answer:
      "We take security seriously. Your data is encrypted, and we use secure authentication to protect your portfolios, client details, and invoices.",
  },
  {
    question: "Can I use FreelancerHub on mobile?",
    answer:
      "Yes, our platform is fully responsive, so you can manage your freelance business from your phone, tablet, or desktop.",
  },
];

const FAQs = () => {
  const [openIndex, setOpenIndex] = useState<number | null>(null);

  const toggleFAQ = (index: number) => {
    setOpenIndex(openIndex === index ? null : index);
  };

  return (
    <section className="py-16 ">
      <MaxWidthWrapper className="pb-20">
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.5 }}
          className="text-center"
        >
          <div className="space-y-2">
            <h2 className="text-3xl font-bold tracking-tighter sm:text-4xl md:text-5xl">
              Frequently Asked Questions
            </h2>
            <p className="max-w-[700px] text-gray-500 md:text-xl/relaxed lg:text-base/relaxed xl:text-xl/relaxed mx-auto">
              Get quick answers about using the Freelancer Portfolio & Invoice
              Generator—from creating stunning portfolios to sending
              professional invoices.
            </p>
          </div>
          <div className="max-w-3xl mx-auto space-y-4">
            {faqs.map((faq, index) => (
              <div
                key={index}
                className={cn(
                  " rounded-lg shadow-md overflow-hidden",
                  openIndex == index && "border border-high "
                )}
              >
                <button
                  onClick={() => toggleFAQ(index)}
                  className={cn(
                    "w-full text-left px-6 py-4 flex justify-between items-center hover:bg-high group  ",
                    openIndex === index && "bg-high text-black"
                  )}
                >
                  <span
                    className={cn(
                      "text-lg font-semibold text-white group-hover:text-black ",
                      InterFont.className,
                      openIndex === index && "bg-high text-black"
                    )}
                  >
                    {faq.question}
                  </span>
                  <span>{openIndex === index ? "−" : "+"}</span>
                </button>
                {openIndex === index && (
                  <div className="px-6 py-4 border-t border-high ">
                    <p className="text-white text-sm text-justify">
                      {faq.answer}
                    </p>
                  </div>
                )}
              </div>
            ))}
          </div>
        </motion.div>
      </MaxWidthWrapper>
    </section>
  );
};

export default FAQs;
