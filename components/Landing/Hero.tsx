"use client";
import React from "react";
import MaxWidthWrapper from "../Shared/maxWidthWrapper";
import { Inter } from "next/font/google";
import { cn } from "@/lib/utils";
import { Button } from "../ui/button";
import Image from "next/image";
import userImage from "@/public/MyImage-removebg-preview.png";

import Project1 from "@/public/projectherosectiondisplay/1.png";
import Project2 from "@/public/projectherosectiondisplay/2.png";
import Project3 from "@/public/projectherosectiondisplay/3.png";
import Project4 from "@/public/projectherosectiondisplay/4.png";
import {
  Calendar,
  Download,
  FacebookIcon,
  LinkedinIcon,
  LucideTwitter,
} from "lucide-react";
import { useRouter } from "next/navigation";

const InterFont = Inter({ weight: "600", subsets: ["latin"] });

export const Hero = () => {
  const router = useRouter();
  return (
    <div>
      <MaxWidthWrapper className="flex flex-col lg:grid lg:grid-cols-2 md:grid-cols-1 md:grid min-h-screen gap-8 py-12">
        <div className="max-w-4xl text-start flex flex-col justify-center gap-3 order-1 lg:order-1">
          <h1
            className={cn(
              "text-3xl sm:text-4xl md:text-5xl lg:text-6xl text-high",
              InterFont.className
            )}
          >
            Showcase Your Work. Manage Clients. Get Paid—All in One Place.
          </h1>
          <p className="text-base sm:text-lg md:text-xl lg:text-2xl">
            Build a stunning portfolio, track your time, and send professional
            invoices effortlessly. Designed for freelancers, by freelancers.
          </p>

          <div className="CTA flex flex-col sm:flex-row gap-3 justify-start mt-4">
            <Button
              variant={"default"}
              className="bg-high w-full sm:w-auto"
              onClick={() => router.push("/signup")}
            >
              Get started for free
            </Button>

            {/* Will add the demo soon */}

            {/* <Button
              variant={"secondary"}
              className="w-full sm:w-auto hover:cursor-not-allowed"
            >
              See A Demo
            </Button> */}
          </div>
        </div>
        <div className="display perspective-distant drop-shadow-xs drop-shadow-black order-1 lg:order-2">
          <div className="h-full w-full flex justify-center align-middle items-center px-4 sm:px-6 md:px-8 lg:px-10">
            <div className="min-h-[30rem] bg-black w-full border border-white/40 shadow-2xs shadow-white rounded-3xl p-3 sm:p-5 USERINFO grid grid-cols-6 gap-2 sm:gap-4">
              <div className="flex flex-col sm:flex-row gap-2 justify-between align-middle items-center w-full col-span-6 border border-gray-800 rounded-xl max-h-max p-1 bg-[#0a0a0a]">
                <div className="flex justify-center align-middle items-center sm:items-start gap-3">
                  <div className="w-10 h-10 sm:w-14 sm:h-14 rounded-full">
                    <Image
                      src={userImage}
                      height={500}
                      width={500}
                      alt="userimage"
                      className="w-full h-full rounded-full object-cover"
                    />
                  </div>
                  <div className="text-center sm:text-left">
                    <h1 className="text-high text-lg sm:text-xl font-semibold">
                      Ankit Mishra
                    </h1>
                    <p className="text-gray-800 text-sm">@ankitmishra</p>
                  </div>
                </div>
                <div className="socials flex justify-center align-middle items-center gap-2 mt-2 sm:mt-0">
                  <LucideTwitter size={18} color="gray" />
                  <FacebookIcon size={18} color="gray" />
                  <LinkedinIcon size={18} color="gray" />
                </div>
              </div>
              <div className="flex flex-col gap-3 bg-[#0a0a0a] rounded-xl border border-gray-800/40 p-2 col-span-6 md:col-span-3 max-h-max">
                <h1 className="font-semibold text-gray-500 text-sm">
                  My Works
                </h1>
                <div className="flex flex-wrap gap-2 sm:gap-4 justify-center sm:justify-start">
                  <Image
                    src={Project1}
                    height={500}
                    width={200}
                    alt="userimage"
                    className="size-16 sm:size-20 rounded-2xl object-cover"
                  />
                  <Image
                    src={Project2}
                    height={500}
                    width={200}
                    alt="userimage"
                    className="size-16 sm:size-20 rounded-2xl object-cover"
                  />
                  <Image
                    src={Project3}
                    height={500}
                    width={200}
                    alt="userimage"
                    className="size-16 sm:size-20 rounded-2xl object-cover"
                  />
                  <Image
                    src={Project4}
                    height={500}
                    width={200}
                    alt="userimage"
                    className="size-16 sm:size-20 rounded-2xl object-cover"
                  />
                </div>
              </div>
              <div className="design_exploration border rounded-2xl max-h-max p-2 col-span-6 md:col-span-3 flex-col flex gap-3 border-gray-800">
                <div className="bg-[#0a0a0a] rounded-xl border border-gray-800/40 p-3">
                  <div className="flex items-center justify-between mb-2">
                    <h3 className="text-white text-xs sm:text-sm font-medium">
                      Upcoming
                    </h3>
                    <Calendar size={14} className="text-gray-400" />
                  </div>
                  <div className="space-y-2">
                    <div className="flex gap-2 items-start">
                      <div className="bg-gray-800 text-white text-xs p-1 rounded">
                        <span>10:30</span>
                      </div>
                      <div>
                        <p className="text-white text-xs">Client Meeting</p>
                        <p className="text-gray-500 text-xs">Smith Agency</p>
                      </div>
                    </div>
                    <div className="flex gap-2 items-start">
                      <div className="bg-gray-800 text-white text-xs p-1 rounded">
                        <span>14:00</span>
                      </div>
                      <div>
                        <p className="text-white text-xs">Design Review</p>
                        <p className="text-gray-500 text-xs">Internal</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div className="bg-[#0a0a0a] rounded-xl border border-gray-800/40 p-3">
                  <div className="flex items-center justify-between mb-2">
                    <h3 className="text-white text-xs sm:text-sm font-medium">
                      Latest Invoice
                    </h3>
                    <Download size={14} className="text-gray-400" />
                  </div>
                  <div className="space-y-1 mb-2">
                    <div className="flex justify-between text-xs">
                      <span className="text-gray-400">Smith Agency</span>
                      <span className="text-white">$1,000.00</span>
                    </div>
                    <div className="flex justify-between text-xs">
                      <span className="text-gray-400">Status</span>
                      <span className="text-green-500">PAID</span>
                    </div>
                  </div>
                  <div className="text-center mt-3">
                    <button className="text-xs bg-gray-800 hover:bg-gray-700 text-white py-1 px-3 rounded-full">
                      View All Invoices
                    </button>
                  </div>
                </div>
              </div>
              <div className="grid grid-cols-3 sm:grid-cols-3 gap-3 sm:gap-4 text-center justify-center align-middle items-center w-full col-span-6">
                <div className="bg-[#0a0a0a] rounded-xl border border-gray-800/40 p-3">
                  <h3 className="text-gray-400 text-xs sm:text-sm">
                    Total Projects
                  </h3>
                  <p className="text-white text-lg sm:text-xl font-bold mt-1">
                    24
                  </p>
                </div>
                <div className="bg-[#0a0a0a] rounded-xl border border-gray-800/40 p-3">
                  <h3 className="text-gray-400 text-xs sm:text-sm">
                    Hours Tracked
                  </h3>
                  <p className="text-white text-lg sm:text-xl font-bold mt-1">
                    1,248
                  </p>
                </div>
                <div className="bg-[#0a0a0a] rounded-xl border border-gray-800/40 p-3">
                  <h3 className="text-gray-400 text-xs sm:text-sm">
                    Total Earned
                  </h3>
                  <p className="text-white text-lg sm:text-xl font-bold mt-1">
                    $48,350
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </MaxWidthWrapper>
    </div>
  );
};
